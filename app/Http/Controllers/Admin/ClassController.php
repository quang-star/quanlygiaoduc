<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\CheckExercise;
use App\Models\ClassModel;
use App\Models\Contract;
use App\Models\Course;
use App\Models\Shift;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function getIndex(Request $request)
    {
        $param = $request->all();
        $classes = ClassModel::with(['course', 'teacher'])
            ->withCount('contracts');
            $teachers = User::where('role', User::ROLE_TEACHER)->get();
            $certificates = Certificate::all();
            $courses = Course::all();
            $datas = [];
            if($request->filled('teacher_id')) {
                $datas['teacher_id'] = $request->get('teacher_id');
                $classes = $classes->where('teacher_id', $request->teacher_id);
            }
            if($request->filled('course_id')) {
                $datas['course_id'] = $request->get('course_id');
                $classes = $classes->where('course_id', $request->course_id);
            }
            if($request->filled('certificate_id')) {
                $datas['certificate_id'] = $request->get('certificate_id');
                $classes = $classes->where('certificate_id', $request->certificate_id);
            }
            if($request->filled('status')) {
                $datas['status'] = $request->get('status');
                if($request->get('status') == 'scheduled') {
                    $classes = $classes->where('status', ClassModel::SCHEDULED);
                }else if($request->get('status') == 'running') {
                    $classes = $classes->where('status', ClassModel::RUNNING);
                }else if($request->get('status') == 'completed') {
                    $classes = $classes->where('status', ClassModel::COMPLETED);
                }else if($request->get('status') == 'cancelled') {
                    $classes = $classes->where('status', ClassModel::CANCELLED);
                }
               
            }
            $classes = $classes->get();

        return view('admin.classes.class', compact('classes', 'teachers', 'certificates', 'courses', 'datas'));
    }


    public function addClass(Request $request)
    {
        $courses = Course::all();
        $teachers = User::where('role', User::ROLE_TEACHER)->get();
        $supporters = User::where('role', User::ROLE_SUPPOTER)->get();

        // Nếu có course_id truyền qua query (?course_id=xxx)
        $selectedCourse = null;
        if ($request->has('course_id')) {
            $selectedCourse = Course::find($request->course_id);
        }

        // Lấy danh sách học viên có hợp đồng, mà chưa có lớp
        // $students = User::where('role', User::ROLE_STUDENT)->get();
        $students = DB::table('contracts')
            ->join('student_profiles', 'contracts.student_profile_id', '=', 'student_profiles.id')
            ->join('users', 'student_profiles.student_id', '=', 'users.id')
            ->whereNull('contracts.class_id')
            ->select('users.id', 'users.name', 'users.phone_number', 'contracts.course_id', 'contracts.class_id')
            ->get();
        $shifts = Shift::select('id', 'start_time', 'end_time')->get();
        return view('admin.classes.add-class', compact(
            'courses',
            'teachers',
            'supporters',
            'students',
            'selectedCourse',
            'shifts'
        ));
    }

    public function storeClass(Request $request)
    {
        // Check tên lớp trùng lập
        $existClassName = ClassModel::where('name', $request->name)->exists();
        if ($existClassName) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tên lớp đã tồn tại, vui lòng nhập tên khác!');
        }
        // Check ngày kết thúc > khai giảng
        if ($request->end_date && $request->end_date < $request->start_date) {
            return redirect()->back()->withInput()->with('error', 'Ngày kết thúc phải sau ngày khai giảng!');
        }
        // Xử lý schedule JSON
        $scheduleData = [];
        if ($request->has('schedule') && $request->has('shift_id')) {
            $days = $request->schedule;
            $shifts = $request->shift_id;

            foreach ($days as $index => $day) {
                if (!empty($day) && !empty($shifts[$index])) {
                    $scheduleData[] = [
                        'day' => $day,
                        'shift' => (int) $shifts[$index],
                    ];
                }
            }
        }
        $schedule = json_encode($scheduleData, JSON_UNESCAPED_UNICODE);

        // Sinh danh sách ngày học (day_learn)
        $dayLearn = [];

        if ($request->start_date && $request->end_date && !empty($scheduleData)) {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $period = CarbonPeriod::create($start, $end);

            // Lấy danh sách số thứ trong tuần từ scheduleData
            // VD: ["Thứ 2", "Thứ 5"] -> [1, 4]
            $dayNumbers = collect($scheduleData)->map(function ($item) {
                $map = [
                    'Thứ 2' => 1,
                    'Thứ 3' => 2,
                    'Thứ 4' => 3,
                    'Thứ 5' => 4,
                    'Thứ 6' => 5,
                    'Thứ 7' => 6,
                    'Chủ nhật' => 7,
                ];
                return $map[$item['day']] ?? null;
            })->filter()->values();

            foreach ($period as $date) {
                // isoFormat('E') trả về: 1 (Thứ 2) → 7 (Chủ nhật)
                if ($dayNumbers->contains($date->isoFormat('E'))) {
                    $dayLearn[] = $date->format('Y-m-d');
                }
            }
        }
        // Tạo lớp học
        $class = ClassModel::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?? null,
            'course_id' => $request->course_id,
            'total_lesson' => $request->total_lesson,
            'lesson_per_week' => $request->lesson_per_week,
            'min_student' => $request->min_student,
            'max_student' => $request->max_student,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
            'schedule' => $schedule,                 // VD: [{"day":"Thứ 2","shift":1},{"day":"Thứ 5","shift":2}]
            'day_learn' => implode(',', $dayLearn), // VD: "2025-10-13,2025-10-16,..."
            'note' => $request->note,
        ]);
        // Cập nhật class_id trong bảng contracts
        if (!empty($request->students)) {
            // 1️⃣ Lấy danh sách student_profile_id tương ứng với các user_id (student_id)
            $studentProfileIds = DB::table('student_profiles')
                ->whereIn('id', $request->students)
                ->pluck('id')
                ->toArray();

            // 2️⃣ Cập nhật class_id trong bảng contracts
            DB::table('contracts')
                ->whereIn('student_profile_id', $studentProfileIds)
                ->update(['class_id' => $class->id]);

            // 3️⃣ Cập nhật class_id trong bảng student_profiles
            DB::table('student_profiles')
                ->whereIn('id', $studentProfileIds)
                ->update(['class_id' => $class->id]);
        }
        return redirect('admin/classes/class')->with('success', 'Thêm lớp học mới thành công!');
    }

    public function editClass($id)
    {
        $class = ClassModel::findOrFail($id);
        $shifts = Shift::all();

        // Format ngày cho input
        $class->start_date = $class->start_date ? \Carbon\Carbon::parse($class->start_date)->format('Y-m-d') : null;
        $class->end_date = $class->end_date ? \Carbon\Carbon::parse($class->end_date)->format('Y-m-d') : null;

        $courses = Course::all();
        $teachers = User::where('role', User::ROLE_TEACHER)->get();
        $supporters = User::where('role', User::ROLE_SUPPOTER)->get();

        // 1) Học viên đã thuộc lớp này (lấy user.id)
        $selectedStudents = DB::table('contracts')
            ->join('student_profiles', 'contracts.student_profile_id', '=', 'student_profiles.id')
            ->join('users', 'student_profiles.student_id', '=', 'users.id')
            ->where('contracts.class_id', $id)
            ->select('student_profiles.id as student_id', 'users.name', 'users.phone_number')
            ->distinct()
            ->get();

        // Danh sách id dạng array (dùng cho in_array trong blade)
        $studentIdsInClass = $selectedStudents->pluck('student_id')->map(fn($v) => (int)$v)->toArray();

        // 2) Học viên của cùng khóa học: chưa có lớp OR đang ở lớp này (để hiển thị cả 2 nhóm trong modal)
        $students = DB::table('contracts')
            ->join('student_profiles', 'contracts.student_profile_id', '=', 'student_profiles.id')
            ->join('users', 'student_profiles.student_id', '=', 'users.id')
            ->where('contracts.course_id', $class->course_id)
            ->where(function ($q) use ($id) {
                // include those without class, or those already in this class (so checkbox can be checked)
                $q->whereNull('contracts.class_id')
                    ->orWhere('contracts.class_id', $id);
            })
            ->select('student_profiles.id', 'users.name', 'users.phone_number', 'contracts.course_id', 'contracts.class_id')
            ->distinct()
            ->get();

        return view('admin.classes.edit-class', compact(
            'class',
            'courses',
            'teachers',
            'supporters',
            'students',
            'selectedStudents',
            'studentIdsInClass',
            'shifts'
        ));
    }

    public function updateClass(Request $request, $id)
    {
        $param = $request->all();
        //dd($param);
        $class = ClassModel::findOrFail($id);
        // dd($class);

        // Validate name uniqueness (exclude current)
        if (ClassModel::where('name', $request->name)->where('id', '!=', $id)->exists()) {
            return back()->withInput()->with('error', 'Tên lớp đã tồn tại!');
        }

        // Date check
        if ($request->end_date && $request->end_date < $request->start_date) {
            return back()->withInput()->with('error', 'Ngày kết thúc phải sau ngày khai giảng!');
        }

        // Build schedule JSON
        $scheduleData = [];
        if ($request->schedule && $request->shift_id) {
            foreach ($request->schedule as $i => $day) {
                if (!empty($day) && !empty($request->shift_id[$i])) {
                    $scheduleData[] = [
                        'day' => $day,
                        'shift' => (int)$request->shift_id[$i],
                    ];
                }
            }
        }
        $schedule = json_encode($scheduleData, JSON_UNESCAPED_UNICODE);

        // Build day_learn if needed (same logic as store)
        $dayLearn = [];
        if ($request->start_date && $request->end_date && !empty($scheduleData)) {
            $map = [
                'Thứ 2' => 1,
                'Thứ 3' => 2,
                'Thứ 4' => 3,
                'Thứ 5' => 4,
                'Thứ 6' => 5,
                'Thứ 7' => 6,
                'Chủ nhật' => 7
            ];
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $period = CarbonPeriod::create($start, $end);
            $dayNumbers = collect($scheduleData)->map(fn($d) => $map[$d['day']] ?? null)->filter();

            foreach ($period as $date) {
                if ($dayNumbers->contains($date->isoFormat('E'))) {
                    $dayLearn[] = $date->format('Y-m-d');
                }
            }
        }

        // Update class
        $class->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?? null,
            'course_id' => $request->course_id,
            'total_lesson' => $request->total_lesson,
            'lesson_per_week' => $request->lesson_per_week,
            'min_student' => $request->min_student,
            'max_student' => $request->max_student,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
            'schedule' => $schedule,
            'day_learn' => implode(',', $dayLearn),
            'note' => $request->note,
        ]);

        // Remove old assignments: gỡ class_id ở contracts & student_profiles cho lớp này
        $oldProfileIds = DB::table('student_profiles')->where('class_id', $class->id)->pluck('id')->toArray();
        if (!empty($oldProfileIds)) {
            DB::table('contracts')->whereIn('student_profile_id', $oldProfileIds)->update(['class_id' => null]);
            DB::table('student_profiles')->whereIn('id', $oldProfileIds)->update(['class_id' => null]);
        }

        // Assign new students if any: request->students contains users.id
        // dd($request->students);
        StudentProfile::where('class_id', $class->id)->where('status', StudentProfile::STATUS_LEARNING)
        ->update(['class_id' => null, 'status' => StudentProfile::STATUS_WAIT_CLASS]);
        Contract::where('class_id', $class->id)->update(['class_id' => null]);
        if (!empty($request->students)) {
            foreach ($request->students as $studentProfileId => $value) {
                $studentProfile = StudentProfile::find($value);
                if ($studentProfile) {
                    $studentProfile->update(['class_id' => $class->id,
                    'status' => StudentProfile::STATUS_LEARNING],


                );

                    $contract = Contract::where('student_profile_id', $value)->first();
                    if ($contract) {
                        $contract->update(['class_id' => $class->id]);
                    }
                }
            }
        }


        return redirect('admin/classes/class')->with('success', 'Cập nhật lớp học thành công!');
    }





    public function deleteClass($id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            $class->delete();


            return redirect()->back()->with('success', 'Xóa lớp học thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xóa lớp học. Vui lòng thử lại!');
        }
    }

    public function getSchedule($id)
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

        if (!$class) {
            return redirect('admin/classes/class')->with('error', 'Không tìm thấy lớp học!');
        }

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

        return view('admin.classes.class-schedule', [
            'class' => $class,
            'schedules' => json_encode($schedules, JSON_UNESCAPED_UNICODE)
        ]);
    }



    public function getAttendance($id, Request $request)
    {
        // === Lấy thông tin lớp học ===
        $class = DB::table('classes')
            ->where('classes.id', $id)
            ->select(
                'classes.id',
                'classes.name as class_name',
                'classes.teacher_id',
                'classes.supporter_id',
                'classes.start_date',
                'classes.end_date',
                'classes.day_learn'
            )
            ->first();

        if (!$class) {
            return redirect()->back()->with('error', 'Không tìm thấy lớp học!');
        }

        $teacher = DB::table('users')->where('id', $class->teacher_id)->value('name');
        $supporter = DB::table('users')->where('id', $class->supporter_id)->value('name');

        // === Lấy ngày được chọn từ lịch (hoặc mặc định hôm nay) ===
        $selectedDate = $request->query('date', Carbon::now()->toDateString());

        // === Lấy học viên trong lớp ===
        $students = DB::table('contracts')
            ->join('student_profiles', 'contracts.student_profile_id', '=', 'student_profiles.id')
            ->join('users', 'student_profiles.student_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.phone_number', 'users.email', 'student_profiles.id as student_profile_id')
            ->distinct()
            ->where('contracts.class_id', $id)
            ->get();

        // === Lấy học viên đã điểm danh trong ngày được chọn ===
        $attendedStudents = DB::table('attendances')
            ->where('class_id', $id)
            ->whereDate('time_attendance', $selectedDate)
            ->pluck('student_profile_id')
            ->toArray();

        // === Lấy học viên đã hoàn thành bài tập trong ngày được chọn ===
        $checkedExercises = DB::table('check_exercises')
            ->where('class_id', $id)
            ->whereDate('time_check', $selectedDate)
            ->pluck('student_profile_id')
            ->toArray();

        // === TÍNH SỐ BUỔI THEO LỊCH (tính đến ngày được chọn) ===
        $scheduledDates = [];
        if (!empty($class->day_learn)) {
            $allDates = array_map('trim', explode(',', $class->day_learn));
            foreach ($allDates as $d) {
                if (empty($d)) continue;
                try {
                    $dt = Carbon::parse($d)->toDateString();
                } catch (\Exception $e) {
                    continue;
                }
                if ($dt <= $selectedDate) {
                    $scheduledDates[] = $dt;
                }
            }
        }
        $totalLessionFromStart = count($scheduledDates);

        // === Đếm số buổi học viên đã có mặt (<= ngày được chọn) ===
        $presentCounts = DB::table('attendances')
            ->select('student_profile_id', DB::raw('COUNT(*) as total'))
            ->where('class_id', $id)
            ->whereDate('time_attendance', '<=', $selectedDate)
            ->groupBy('student_profile_id')
            ->pluck('total', 'student_profile_id')
            ->toArray();

        // === Tính số buổi vắng ===
        $absentCounts = [];
        foreach ($students as $stu) {
            $present = $presentCounts[$stu->student_profile_id] ?? 0;
            $absentCounts[$stu->student_profile_id] = max(0, $totalLessionFromStart - $present);
        }

        // === Trả về view ===
        return view('admin.classes.attendance', [
            'class' => $class,
            'teacherName' => $teacher,
            'supporterName' => $supporter,
            'students' => $students,
            'attendedStudents' => $attendedStudents,
            'checkedExercises' => $checkedExercises, // ✅ thêm dòng này
            'attendanceDate' => $selectedDate,
            'totalSessionsSoFar' => $totalLessionFromStart,
            'presentCounts' => $presentCounts,
            'absentCounts' => $absentCounts,
        ]);
    }


    public function saveAttendance($id, Request $request)
    {
        // dd($request->all());
        $attendData = $request->input('attendance', []); // Có mặt
        $exerciseData = $request->input('exercise', []); // Làm bài tập
        $dateInput = $request->input('date_implementation');
        $dateAttendance = \Carbon\Carbon::parse($dateInput)->toDateString();

        if (empty($attendData) && empty($exerciseData)) {
            return back()->with('error', 'Chưa chọn học viên nào để lưu dữ liệu!');
        }
        Attendance::where('class_id', $id)
            ->whereDate('time_attendance', $dateAttendance)
            ->delete();

        CheckExercise::where('class_id', $id)

            ->whereDate('time_check', $dateAttendance)
            ->delete();

        // 🔹 Lưu điểm danh
        foreach ($attendData as $studentId => $isPresent) {
            $exists = \App\Models\Attendance::where('student_profile_id', $studentId)
                ->where('class_id', $id)
                ->whereDate('time_attendance', $dateAttendance)
                ->exists();

            if (!$exists) {
                \App\Models\Attendance::create([
                    'student_profile_id' => $studentId,
                    'class_id' => $id,
                    'time_attendance' => $dateAttendance,
                ]);
            }
        }

        // 🔹 Lưu bài tập
        foreach ($exerciseData as $studentId => $isChecked) {
            $exists = \App\Models\CheckExercise::where('student_profile_id', $studentId)
                ->where('class_id', $id)
                ->whereDate('time_check', $dateAttendance)
                ->exists();

            if (!$exists) {
                \App\Models\CheckExercise::create([
                    'student_profile_id' => $studentId,
                    'class_id' => $id,
                    'time_check' => $dateAttendance,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Đã lưu điểm danh và tình trạng bài tập thành công!');
    }

    public function quickSearch(Request $request)
    {
        $keyword = trim($request->input('key_search'));

        $classes = ClassModel::with(['course', 'teacher'])
            ->withCount('contracts')
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($key_search) use ($keyword) {
                    $key_search->where('classes.name', 'like', "%{$keyword}%")
                        ->orWhereHas('course', function ($sub) use ($keyword) {
                            $sub->where('name', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('teacher', function ($sub) use ($keyword) {
                            $sub->where('name', 'like', "%{$keyword}%");
                        });
                });
            })
            ->orderBy('classes.id', 'desc')
            ->get();

        return view('admin.classes.class', compact('classes', 'keyword'));
    }
}
