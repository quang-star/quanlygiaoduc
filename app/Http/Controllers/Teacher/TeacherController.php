<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\FinalExamExport;
use App\Http\Controllers\Controller;
use App\Imports\FinalExamImport;
use App\Models\Attendance;
use App\Models\CheckExercise;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\StudentProfile;
use App\Models\TestResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Event\Code\Test;
use PHPUnit\Framework\MockObject\Builder\Stub;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::user()->id;

        // Lấy tất cả lớp mà giảng viên đang dạy
        $classes = DB::table('classes')
            ->join('users as teachers', 'classes.teacher_id', '=', 'teachers.id')
            ->select(
                'classes.id',
                'classes.name as class_name',
                'teachers.name as teacher_name',
                'classes.schedule',        // JSON lịch học, vd: [{"day":"Thứ 2","shift":6},{"day":"Thứ 5","shift":7}]
                'classes.start_date',
                'classes.end_date'
            )
            ->where('teachers.id', $teacherId)
            ->get();

        if ($classes->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy lớp học!');
        }

        // Lấy thông tin ca học (để lấy time_start, time_end)
        $shifts = DB::table('shifts')->get()->keyBy('id');

        // Map ngày trong tuần sang dayOfWeek của Carbon
        $dayMap = [
            'Chủ nhật' => 0,
            'Thứ 2' => 1,
            'Thứ 3' => 2,
            'Thứ 4' => 3,
            'Thứ 5' => 4,
            'Thứ 6' => 5,
            'Thứ 7' => 6,
        ];

        $schedules = [];

        foreach ($classes as $class) {
            $scheduleData = json_decode($class->schedule, true) ?? [];
            if (empty($scheduleData)) continue;

            $start = \Carbon\Carbon::parse($class->start_date);
            $end = \Carbon\Carbon::parse($class->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayOfWeek = $date->dayOfWeek;

                foreach ($scheduleData as $item) {
                    if (isset($dayMap[$item['day']]) && $dayMap[$item['day']] == $dayOfWeek) {
                        $shift = $shifts[$item['shift']] ?? null;

                        $schedules[] = [
                            'date' => $date->toDateString(),
                            'class_id' => $class->id,
                            'class_name' => $class->class_name,
                            'teacher_name' => $class->teacher_name,
                            'shift' => $item['shift'],
                            'time_start' => $shift ? substr($shift->start_time, 0, 5) : null,
                            'time_end' => $shift ? substr($shift->end_time, 0, 5) : null,
                        ];
                    }
                }
            }
        }

        // Sắp xếp theo ngày
        usort($schedules, fn($a, $b) => strcmp($a['date'], $b['date']));

        // dd($schedules);
        return view('teacher.teach-schedule.index', [
            'classes' => $classes,
            'schedules' => json_encode($schedules, JSON_UNESCAPED_UNICODE),
        ]);
    }


    public function classesIndex(Request $request)
    {
        $teacher_id = Auth::user()->id;
        $param = $request->all();
        $classes = ClassModel::with(['course', 'teacher'])
            ->withCount('contracts')
            ->where('teacher_id', $teacher_id)
            ->get();
        return view('teacher.classes.index', compact('classes'));
    }

    public function classDetailsIndex(Request $request, $classId)
    {
        $date = $request->input('date', date('Y-m-d')); // ngày hiện tại hoặc query
        $class = ClassModel::with(['teacher', 'studentProfiles.student'])
            ->findOrFail($classId);

        // Các ngày học của lớp
        $days = explode(',', $class->day_learn);

        // Lấy dữ liệu điểm danh/bài tập cho ngày này
        $attendanceRecords = Attendance::where('class_id', $class->id)
            ->whereDate('time_attendance', $date)
            ->pluck('student_profile_id')
            ->toArray();

        $assignmentRecords = CheckExercise::where('class_id', $class->id)
            ->whereDate('time_check', $date)
            ->pluck('student_profile_id')
            ->toArray();

        return view('teacher.classes.class-detail', compact(
            'class',
            'days',
            'date',
            'attendanceRecords',
            'assignmentRecords'
        ));
    }

    public function classDetailUpdate(Request $request)
    {
        $classId = $request->input('class_id');
        $date = $request->input('date');

        // Lấy mảng attendance và assignment từ form
        $attendances = $request->input('attendance', []); // student_profile_id => 1
        $assignments = $request->input('assignment', []); // student_profile_id => 1

        // Cập nhật điểm danh
        foreach ($attendances as $studentProfileId => $value) {
            Attendance::updateOrCreate(
                [
                    'class_id' => $classId,
                    'student_profile_id' => $studentProfileId,
                    'time_attendance' => $date,
                ],
                [
                    'updated_at' => now()
                ]
            );
        }

        // Xóa những bản ghi attendance bị bỏ tick (nếu muốn)
        Attendance::where('class_id', $classId)
            ->whereDate('time_attendance', $date)
            ->whereNotIn('student_profile_id', array_keys($attendances))
            ->delete();

        // Cập nhật bài tập
        foreach ($assignments as $studentProfileId => $value) {
            CheckExercise::updateOrCreate(
                [
                    'class_id' => $classId,
                    'student_profile_id' => $studentProfileId,
                    'time_check' => $date,
                ],
                [
                    'updated_at' => now()
                ]
            );
        }

        // Xóa những bản ghi assignment bị bỏ tick (nếu muốn)
        CheckExercise::where('class_id', $classId)
            ->whereDate('time_check', $date)
            ->whereNotIn('student_profile_id', array_keys($assignments))
            ->delete();

        return redirect()->back()->with('success', 'Cập nhật điểm danh và bài tập thành công!');
    }

    public function finalExamIndex(Request $request, $classId)
    {

        $class = ClassModel::with(['teacher', 'studentProfiles.student', 'studentProfiles.testResults'])
            ->findOrFail($classId);
        //dd($class);

        return view('teacher.classes.final-exam', compact(
            'class',
        ));
    }

    public function finalExamUpdate(Request $request)
    {
        $classId = $request->input('class_id');
        $date = $request->input('date', now());
        $class = ClassModel::find($classId);
        $exam_firsts = $request->input('exam-first', []);
        $exam_lasts = $request->input('exam-last', []);
        // dd($exam_firsts, $exam_lasts);
        // Cập nhật điểm đầu vào
        foreach ($exam_firsts as $studentProfileId => $value) {
            if ($value === null || $value === '') continue;

            TestResult::updateOrCreate(
                [
                    'student_profile_id' => $studentProfileId,
                    'result_status' => TestResult::ROLE_FIRST_TEST,
                ],
                [
                    'total_score' => $value,
                    'test_date' => $date,
                    'updated_at' => now()
                ]
            );
            $studentProfile = StudentProfile::find($studentProfileId);


            $studentProfile->update([
                'status' => $this->determineStatus($studentProfile, $value, $class)
            ]);
        }

        // Xóa những bản ghi bỏ trống
        TestResult::where('result_status', TestResult::ROLE_FIRST_TEST)
            ->whereIn('student_profile_id', StudentProfile::where('class_id', $classId)->pluck('id'))
            ->whereNotIn('student_profile_id', array_keys($exam_firsts))
            ->delete();

        // Cập nhật điểm cuối
        foreach ($exam_lasts as $studentProfileId => $value) {
            TestResult::updateOrCreate(
                [
                    'student_profile_id' => $studentProfileId,
                    'result_status' => TestResult::ROLE_OTHER_TEST,
                ],
                [
                    'total_score' => $value,
                    'test_date' => $date,
                    'updated_at' => now()
                ]
            );
        }

        TestResult::where('result_status', TestResult::ROLE_OTHER_TEST)
            ->whereIn('student_profile_id', StudentProfile::where('class_id', $classId)->pluck('id'))
            ->whereNotIn('student_profile_id', array_keys($exam_lasts))
            ->delete();

        return redirect()->back()->with('success', 'Cập nhật điểm thành công!');
    }

    public function exportFinalExam($classId)
    {
        return Excel::download(new FinalExamExport($classId), 'DanhSachDiem.xlsx');
    }

    public function importFinalExam(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'class_id' => 'required',
        ]);

        Excel::import(new FinalExamImport($request->class_id), $request->file('file'));

        return back()->with('success', 'Import điểm thành công!');
    }

    private function determineStatus($studentProfile, $score, $class)
    {
        $level = Level::find($studentProfile->current_level_id);
        if ($score >= $level->max_score) {
            return StudentProfile::STATUS_FINISH;
        }

        $countAttendance = Attendance::where('student_profile_id', $studentProfile->id)->count();
        $countCheckExercise = CheckExercise::where('student_profile_id', $studentProfile->id)->count();

        if (
            $countAttendance / $class->total_lesson >= 0.8
            && $countCheckExercise / $class->total_lesson >= 0.8
        ) {
            return StudentProfile::STATUS_RETAKE;
        }

        return StudentProfile::STATUS_INCOMPLETE;
    }
}
