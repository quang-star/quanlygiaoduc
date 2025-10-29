<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    // TODO: Get all schedule of student
    public function getAllSchedule()
    {
        $studentId = Auth::user()->id;
        // Lấy toàn bộ lớp mà học viên đang theo học (qua bảng contracts)
        $classes = DB::table('contracts')
            ->join('classes', 'contracts.class_id', '=', 'classes.id')
            ->join('users as teachers', 'classes.teacher_id', '=', 'teachers.id')
            ->select(
                'classes.id',
                'classes.name as class_name',
                'teachers.name as teacher_name',
                'classes.schedule',
                'classes.start_date',
                'classes.end_date'
            )
            ->whereExists(function ($query) use ($studentId) {
                $query->select(DB::raw(1))
                    ->from('student_profiles')
                    ->whereRaw('student_profiles.id = contracts.student_profile_id')
                    ->where('student_profiles.student_id', $studentId);
            })->get();
        if ($classes->isEmpty()) {
            return view('student.all-schedule', [
                'class' => null,
                'schedules' => json_encode([]),
            ]);
        }
        // Lấy thông tin ca học
        $shifts = DB::table('shifts')->get()->keyBy('id');
        $dayMap = [
            'Thứ 2' => 1,
            'Thứ 3' => 2,
            'Thứ 4' => 3,
            'Thứ 5' => 4,
            'Thứ 6' => 5,
            'Thứ 7' => 6,
            'Chủ nhật' => 0
        ];
        $allSchedules = [];
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

                        $allSchedules[] = [
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
        // Truyền sang view
        return view('student.all-schedule', [
            'class' => null,
            'schedules' => json_encode($allSchedules, JSON_UNESCAPED_UNICODE),
        ]);
    }


    // lich su hoc
    public function historyLearnedIndex(Request $request)
    {
        $userId = Auth::id();
        // Lấy các hợp đồng (phiếu ghi danh) thông qua student_profiles
        $contracts = Contract::with(['class.course', 'class.teacher'])
            ->whereHas('studentProfile', function ($query) use ($userId) {
                $query->where('student_id', $userId);
            })
            ->get();
        // Lấy danh sách lớp từ hợp đồng
        $classes = $contracts->pluck('class')->filter();
        return view('student.class-learned', compact('classes'));
    }



    // TODO
    public function quickSearchClass(Request $request)
    {
        $student_id = Auth::user()->id;
        $keyword = trim($request->input('key_search'));

        // Lấy các hợp đồng của học viên kèm thông tin lớp, khóa học, giáo viên
        $contracts = Contract::with(['class.course', 'class.teacher'])
            ->where('student_id', $student_id)
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('class', function ($classQuery) use ($keyword) {
                    $classQuery->where('classes.name', 'like', "%{$keyword}%")
                        ->orWhereHas('course', function ($sub) use ($keyword) {
                            $sub->where('name', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('teacher', function ($sub) use ($keyword) {
                            $sub->where('name', 'like', "%{$keyword}%");
                        });
                });
            })
            ->get();

        // Lấy danh sách lớp từ hợp đồng (lọc bỏ null)
        $classes = $contracts->pluck('class')->filter();

        return view('student.class-learned', compact('classes', 'keyword'));
    }


    // lịch học theo lớp học của học viên
    public function studentSchedule($id)
    {
        $class = DB::table('classes')
            ->join('users as teachers', 'classes.teacher_id', '=', 'teachers.id')
            ->select(
                'classes.id',
                'classes.name as class_name',
                'teachers.name as teacher_name',
                'classes.schedule',
                'classes.start_date',
                'classes.end_date'
            )
            ->where('classes.id', $id)
            ->first();

        // if (!$class) {
        //     return redirect('admin/classes/class')->with('error', 'Không tìm thấy lớp học!');
        // }

        // Giải mã JSON schedule
        $scheduleData = json_decode($class->schedule, true) ?? [];

        // Lấy thông tin ca học
        $shifts = DB::table('shifts')->get()->keyBy('id'); // keyBy để dễ truy cập

        // Map tên ngày trong tiếng Việt sang số thứ trong tuần
        $dayMap = [
            'Thứ 2' => 1,
            'Thứ 3' => 2,
            'Thứ 4' => 3,
            'Thứ 5' => 4,
            'Thứ 6' => 5,
            'Thứ 7' => 6,
            'Chủ nhật' => 0
        ];

        $schedules = [];
        $start = \Carbon\Carbon::parse($class->start_date);
        $end = \Carbon\Carbon::parse($class->end_date);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek; // 0: CN, 1: Thứ 2,...

            foreach ($scheduleData as $item) {
                if (isset($dayMap[$item['day']]) && $dayMap[$item['day']] == $dayOfWeek) {
                    $shift = $shifts[$item['shift']] ?? null;

                    $schedules[] = [
                        'date' => $date->toDateString(),
                        'class_name' => $class->class_name,
                        'teacher_name' => $class->teacher_name,
                        'shift' => $item['shift'],
                        'time_start' => $shift ? substr($shift->start_time, 0, 5) : null,
                        'time_end' => $shift ? substr($shift->end_time, 0, 5) : null,
                    ];
                }
            }
        }

        return view('student.student-schedule', [
            'class' => $class,
            'schedules' => json_encode($schedules, JSON_UNESCAPED_UNICODE)
        ]);
    }

    // Lịch sử khóa học + tiền đóng
    public function historyBillIndex(Request $request)
    {
        $param = $request->all();
        $studentId = Auth::user()->id;
        // $contracts = Contract::with('class', 'bills')->where('student_id', $student_id)->get();
        $contracts = DB::table('users')
            ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
            ->join('contracts', 'student_profiles.id', '=', 'contracts.student_profile_id')
            ->join('courses', 'contracts.course_id', '=', 'courses.id')
            ->join('classes', 'contracts.class_id', '=', 'classes.id')
            ->select(
                'classes.*',
                'courses.name as course_name',
                'classes.name as class_name',
                'contracts.id as contract_id',
                'contracts.total_value',
                'contracts.collected',
                'contracts.status',

            )
            ->where('student_profiles.student_id', $studentId)
            ->get();
        return view('student.bill-history', compact('contracts'));
    }

    // TODO: làm btn Xem lịch sử của student
}
