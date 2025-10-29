<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Attendance;
use App\Models\CheckExercise;
use App\Models\ClassModel;
use App\Models\Contract;
use App\Models\Course;
use App\Models\Level;
use App\Models\StudentProfile;
use App\Models\TestResult;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    // protected function listStudent()
    // {
    //     return DB::table('users')->where('users.role', User::ROLE_STUDENT)
    //         ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
    //         ->join('levels', 'student_profiles.current_level_id', '=', 'levels.id')
    //         ->join('courses', 'student_profiles.current_level_id', '=', 'courses.level_id')
    //         ->leftJoin('contracts', function ($join) {
    //             $join->on('users.id', '=', 'contracts.student_id')
    //                 ->on('contracts.course_id', '=', 'courses.id');
    //         })
    //         ->leftJoin('classes', 'classes.id', '=', 'contracts.class_id')
    //         ->select(
    //             'users.id',
    //             'users.name',
    //             'users.email',
    //             'users.phone_number',
    //             'levels.name as level_name',
    //             'classes.id as class_id',
    //             'classes.start_date',
    //             'classes.end_date',
    //             'classes.name as class_name',
    //             'courses.name as course_name',
    //             'student_profiles.status'
    //         )
    //         ->distinct();

    // }
    protected function listStudent()
    {
        return DB::table('users')->where('users.role', User::ROLE_STUDENT)
            ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
            ->leftJoin('levels', 'student_profiles.current_level_id', '=', 'levels.id')
            ->leftJoin('courses', 'student_profiles.current_level_id', '=', 'courses.level_id')
            ->leftJoin('contracts', function ($join) {
                $join->on('student_profiles.id', '=', 'contracts.student_profile_id')
                    ->on('contracts.course_id', '=', 'courses.id');
            })
            ->leftJoin('classes', 'classes.id', '=', 'contracts.class_id')

            // JOIN test_results cho điểm đầu vào (role = 0)
            ->leftJoin('test_results as entry_test', function ($join) {
                $join->on('entry_test.student_profile_id', '=', 'student_profiles.id')
                    ->where('entry_test.result_status', '=', 0);
            })
            // JOIN test_results cho điểm đầu ra (role = 1)
            ->leftJoin('test_results as exit_test', function ($join) {
                $join->on('exit_test.student_profile_id', '=', 'student_profiles.id')
                    ->where('exit_test.result_status', '=', 1);
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone_number',
                'users.birthday',
                'levels.name as level_name',
                'classes.id as class_id',
                'classes.start_date',
                'classes.end_date',
                'classes.name as class_name',
                'courses.name as course_name',
                'student_profiles.id as student_profile_id',
                'student_profiles.status',
                'entry_test.total_score as entry_score',
                'exit_test.total_score as exit_score',

            )
            ->distinct();
    }

    public function index(Request $request)
    {
        // lấy ra danh sách học viên
        $students = $this->listStudent()
            ->orderBy('users.id', 'desc');
        // Lọc dữ liệu
        $datas = [];
        if ($request->filled('course')) {
            $students->where('courses.name', 'like', '%' . $request->course . '%');
            $datas['course'] = $request->course;
        }
        if ($request->filled('class')) {
            $students->where('classes.name', 'like', '%' . $request->class . '%');
            $datas['class'] = $request->class;
        }
        // Lấy dữ liệu sau khi lọc
        $students = $students->get();
        // Lấy ra id của học viên và cập nhật số lượng bản ghi cho từng học viên
        $student_list = array_count_values($students->pluck('id')->toArray());
        foreach ($students as $student) {
            // if(in_array($student->id, $student_list[$student->id])){
            //     $student_list[]
            // }
            //dd($student, $student_list);
            $student->rowspan = $student_list[$student->id];
            $labels = StudentProfile::$statusLabels;
            $status_colors = StudentProfile::$statusColors;
            $student->status_label = $labels[$student->status] ?? 'Không xác định';
            $student->status_color = $status_colors[$student->status] ?? 'Không xác định';
        }

        return view('admin.students.student', compact('students', 'datas'));
    }
    

    /**
     * Summary of edit
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        $students = $this->listStudent()
            ->where('users.id', $id)
            ->get();
        $student = $students->first();
        return view('admin.students.edit-student', compact('students', 'student'));
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $param = $request->all();
        $studentId = $param['student_id'];
        $student = User::find($studentId);

        // nếu không có học viên thì tạo mới
        if (!$student || $student->role !== User::ROLE_STUDENT) {
            $user = User::create([

                'name' => $param['ho_ten'],
                'email' => $param['email'],
                'phone_number' => $param['so_dien_thoai'],
                'birthday' => $param['ngay_sinh'],
                'role' => User::ROLE_STUDENT,
                'password' => bcrypt('123456'),
                // Thêm các trường khác nếu cần
            ]);
            // gửi mail cho người dùng sau khi tạo tài khoản
            MailService::sendMailCreateAccount($student);
            $studentId = $user->id;   
        } else {
            // cập nhật thông tin học viên
            $student->name = $param['ho_ten'];
            $student->email = $param['email'];
            $student->phone_number = $param['so_dien_thoai'];
            $student->birthday = $param['ngay_sinh'];
            $student->save();
        }
        return redirect('/admin/students/edit/' . $studentId)->with('success', 'Cập nhật thông tin học viên thành công.');
    }


    public function updateScore(Request $request)
    {
        $param = $request->all();
        $studentProfileId = $param['student_profile_id'];
        $studentProfile = StudentProfile::find($studentProfileId);
        // lấy ra thông tin điểm đầu vào và điểm đầu ra
        $testResultEntry = TestResult::where('student_profile_id', $studentProfileId)
            ->where('result_status', TestResult::ROLE_FIRST_TEST)->first();

        $testResultExit = TestResult::where('student_profile_id', $studentProfileId)
            ->where('result_status', TestResult::ROLE_OTHER_TEST)->first();
        // cập nhật lại điểm đầu vào
        if ($testResultEntry->total_score != $param['entry_score']) {
            $testResultEntry->total_score = $param['entry_score'];
            $testResultEntry->save();
        }
        // nếu học viên chưa có lớp thì redirect về màn trước
        if ($studentProfile->class_id == null) {
            return redirect()->back()->with('error', 'Học viên chưa có lớp học.');
        }
        if ($param['exit_score']) {
            // cập nhật lại điểm đầu ra
            if (!$testResultExit) {
                TestResult::create([
                    'student_profile_id' => $studentProfileId,
                    'result_status' => TestResult::ROLE_OTHER_TEST,
                    'total_score' => $param['exit_score'],
                ]);
            } else {
                $testResultExit->total_score = $param['exit_score'];
                $testResultExit->save();
            }
            // cập nhật lại trạng thái học viên sau khi có điểm
            $level = Level::find($studentProfile->current_level_id);
            if ($level->max_score <= $param['exit_score']) {
                $studentProfile->status = StudentProfile::STATUS_FINISH;
                $studentProfile->save();
            } else {
                $class = ClassModel::find($studentProfile->class_id);
                $countAttendance = Attendance::where('student_profile_id', $studentProfile->id)->count();
                $countCheckExercise = CheckExercise::where('student_profile_id', $studentProfile->id)->count();
                if (
                    $countAttendance / $class->total_lesson >= 0.8
                    && $countCheckExercise / $class->total_lesson >= 0.8
                ) {
                    $studentProfile->status = StudentProfile::STATUS_RETAKE;
                    $studentProfile->save();
                    return redirect()->back()->with('success', 'Cập nhật đ점 học viên thành cong.');
                }
                $studentProfile->status = StudentProfile::STATUS_INCOMPLETE;
                $studentProfile->save();
            }
        }
        return redirect()->back()->with('success', 'Cập nhật điểm học viên thành công.');
    }




    public function exportSelected(Request $request)
    {
        // Lấy ra danh sách học viên cần export
        $ids = json_decode($request->selected_ids, true);

        // Nếu muốn lọc đúng theo dữ liệu ở index()
        $students = $this->listStudent()
            ->when($request->filled('course'), function ($query) use ($request) {
                $query->where('courses.name', 'like', '%' . $request->course . '%');
            })
            ->when($request->filled('class'), function ($query) use ($request) {
                $query->where('classes.name', 'like', '%' . $request->class . '%');
            })
            ->whereIn('users.id', $ids)
            ->orderBy('users.id', 'desc')
            ->get();
        return Excel::download(new StudentsExport($students), 'hoc_vien_duoc_chon.xlsx');
    }



    public function importScore(Request $request)
    {
        // validate file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        // import file
        $import = new StudentsImport();
        Excel::import($import, $request->file('file'));
        // lấy ra dữ liệu trong file
        $data = $import->getImportedData();
        $errors = [];
        $success = [];
        foreach ($data as $item) {
            $studentProfile = StudentProfile::find($item['student_profile_id']);
            if ($studentProfile) {
                $contract = Contract::where('student_profile_id', $studentProfile->id)->first();
                if (!$contract) {
                    $errors[] = "Học viên {$studentProfile->student->name} chưa có hợp đồng.";
                    continue;
                }
                if (empty($contract->class_id)) {
                    $errors[] = "Học viên {$studentProfile->student->name} chưa có lớp học.";
                    continue;
                }
                // Xử lý điểm đầu vào
                if ($item['entry_score'] !== null) {
                    $testResult = TestResult::firstOrNew([
                        'student_profile_id' => $studentProfile->id,
                        'result_status' => TestResult::ROLE_FIRST_TEST
                    ]);
                    $testResult->total_score = $item['entry_score'];
                    $testResult->save();
                }
                // Xử lý điểm đầu ra
                if ($item['exit_score'] !== null) {
                    $testResult = TestResult::firstOrNew([
                        'student_profile_id' => $studentProfile->id,
                        'result_status' => TestResult::ROLE_OTHER_TEST
                    ]);
                    $testResult->total_score = $item['exit_score'];
                    $testResult->save();

                    $level = Level::find($studentProfile->current_level_id);
                    if ($level->max_score <= $item['exit_score']) {
                        $studentProfile->status = StudentProfile::STATUS_FINISH;
                        $studentProfile->save();
                    } else {

                        $class = ClassModel::find($studentProfile->class_id);
                        $countAttendance = Attendance::where('student_profile_id', $studentProfile->id)->count();
                        $countCheckExercise = CheckExercise::where('student_profile_id', $studentProfile->id)->count();

                        if (
                            $countAttendance / $class->total_lesson >= 0.8
                            && $countCheckExercise / $class->total_lesson >= 0.8
                        ) {
                            $studentProfile->status = StudentProfile::STATUS_RETAKE;
                            $studentProfile->save();
                            // return redirect()->back()->with('success', 'Cập nhật đ점 học viên thành cong.');
                        }

                        $studentProfile->status = StudentProfile::STATUS_INCOMPLETE;
                        $studentProfile->save();
                    }
                }
                $studentProfile->save();
                $success[] = "✅ Import điểm thành công cho học viên {$studentProfile->student->name}.";
            }
        }
        // Tách riêng success và errors
        // $messagesSuccess = $success ?? [];
        // $messagesErrors = $errors ?? [];

        // // Lưu vào session
        // return redirect()->back()->with([
        //     'success_messages' => $messagesSuccess,
        //     'error_messages' => $messagesErrors,
        // ]);
        return redirect()->back()->with('success', 'Import điểm học viên thành công.');
    }
    public function getStudentProgress($class_id, $student_id)
    {
        // 1. Lấy thông tin lớp học
        $class = ClassModel::find($class_id);

        // 2. Đếm số buổi học viên đã điểm danh
        $attendanceCount = Attendance::where('class_id', $class_id)
            ->where('student_id', $student_id)
            ->count();

        // 3. Đếm số lần học viên nộp bài
        $exerciseCount = CheckExercise::where('class_id', $class_id)
            ->where('student_id', $student_id)
            ->count();

        // 4. Tổng buổi học của lớp
        $totalLessons = $class->total_lesson ?? 0;

        // 5. Tính tỷ lệ (chống chia 0)
        $attendanceRate = $totalLessons > 0 ? ($attendanceCount / $totalLessons) * 100 : 0;
        $exerciseRate   = $totalLessons > 0 ? ($exerciseCount / $totalLessons) * 100 : 0;

        return response()->json([
            'student_id' => $student_id,
            'class_id' => $class_id,
            'total_lessons' => $totalLessons,
            'attended' => $attendanceCount,
            'submitted_exercises' => $exerciseCount,
            'attendance_rate' => round($attendanceRate, 2),
            'exercise_rate' => round($exerciseRate, 2),
        ]);
    }
}
