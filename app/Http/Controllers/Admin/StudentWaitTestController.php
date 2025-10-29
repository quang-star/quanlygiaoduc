<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendAccountStudentMail;
use App\Models\Certificate;
use App\Models\Language;
use App\Models\Level;
use App\Models\StudentProfile;
use App\Models\TestResult;
use App\Models\User;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentWaitTestController extends Controller
{
    public function waitTest(Request $request)
    {
        $param = $request->all();
        $students = DB::table('users')->where('role', User::ROLE_STUDENT)
            ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
            ->join('languages', 'student_profiles.language_id', '=', 'languages.id')
            ->join('certificates', 'student_profiles.certificate_id', '=', 'certificates.id')
            ->join('test_results', 'test_results.student_profile_id', '=', 'student_profiles.id')
            ->leftJoin('entrance_exams', 'entrance_exams.certificate_id', '=', 'student_profiles.certificate_id')

            ->where('student_profiles.status', '=', StudentProfile::STATUS_WAIT_TEST) // Đổi sang status chờ test
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone_number',
                'languages.name as language_name',
                'certificates.name as certificate_name',
                'student_profiles.id as student_profile_id',
                'student_profiles.status as student_status',
                'test_results.test_date as register_date',
                'entrance_exams.pdf_test_file',
            )

            ->orderBy('test_results.test_date', 'desc');
            $datas = [];
        if ($request->filled('language_id')) {
            $datas['language_id'] = $request->language_id;
            $students->where('languages.id', $request->language_id);
        }
        if ($request->filled('certificate_id')) {
            $datas['certificate_id'] = $request->certificate_id;
            $students->where('certificates.id', $request->certificate_id);
        }
        if ($request->filled('status')) {
            $datas['status'] = $request->status;
            $now = Carbon::now()->format('Y-m-d');
            if ($request->status == 1) {
                $students->whereDate('test_results.test_date', $now);
            } else if ($request->status == 2) {
                $students->whereDate('test_results.test_date', '>', $now);
            } else {
                $students->whereDate('test_results.test_date', '<', $now);
            }
        }
        $students = $students->get();
        $languages = Language::all();
        $certificates = Certificate::all();

        return view('admin.students.student-wait-test', compact('students', 'languages', 'certificates', 'datas'));
    }
    public function createWaitTest()
    {
        $languages = Language::all();

        $certificates = Certificate::all();
        return view('admin.students.add-student-wait-test', compact('languages', 'certificates'));
    }
    public function storeWaitTest(Request $request)
    {
        $param = $request->all();
        $student = User::where('email', $param['email'])->first();
        if (!$student) {
            // tạo tài khoản học viên nếu chưa có
            $student = User::create([
                'name' => $param['name'],
                'email' => $param['email'],
                'phone_number' => $param['phone_number'],
                'birthday' => $param['birthday'],
                'password' => bcrypt('123456'), // Mật tỷ mặc định
                'role' => User::ROLE_STUDENT,

            ]);
            //MailService::sendMailCreateAccount($student);
            // thêm vào queue đợi xử lý gửi mail
            SendAccountStudentMail::dispatch($student->id);
            // chạy job trên queue php artisan queue:work
        } else {
            if($student->role != User::ROLE_STUDENT){
                return redirect()->back()->with('error', 'Email nây đa học viên');
            }
            if ($student->role == User::ROLE_STUDENT) {
                $studentProfile = StudentProfile::where('student_id', $student->id)
                    ->where('language_id', $param['language'])
                    ->where('certificate_id', $param['certificate'])
                    ->where('status', StudentProfile::STATUS_WAIT_TEST)
                    ->first();
                if ($studentProfile) {
                    return redirect()->back()->with('error', 'Email nây đa học viên');
                }
            }
        }
        // tạo mới profile cho học viên
        $studentProfile = StudentProfile::create([
            'student_id' => $student->id,
            'language_id' => $param['language'],
            'certificate_id' => $param['certificate'],
            'status' => StudentProfile::STATUS_WAIT_TEST,

        ]);
        TestResult::create([
            'student_profile_id' => $studentProfile->id,
            'language_id' => $param['language'],
            'certificate_id' => $param['certificate'],
            'test_date' => $param['time_test'],
            'total_score' => -1, // chưa có điểm
            'result_status' => TestResult::ROLE_FIRST_TEST, // test đầu vào

        ]);
        return redirect('admin/students/wait-test')->with('success', 'Thêm học viên chờ test thành công!');
    }
    public function deleteWaitTest(Request $request)
    {
        $param = $request->all();

        $studentProfileId = $param['studentProfileId'];
        //$date = StudentProfile::find($studentProfileId)->select('created_at')->first();
        // TestResult::where('student_id', $param['studentId'])
        //     ->whereDate('test_date', $date->created_at)
        //     ->delete();
        TestResult::where('student_profile_id', $studentProfileId)->delete();
        StudentProfile::where('id', $studentProfileId)->delete();
        return redirect('admin/students/wait-test')->with('success', 'Xóa học viên chờ test thành công!');
        // Lưu lại thông tin người dùng chỉ xóa 2 bảng trên
    }

    public function editWaitTest(Request $request, $studentProfileId)
    {
        $param = $request->all();

        $studentProfile = StudentProfile::find($studentProfileId);
        $student = User::find($studentProfile->student_id);
        $languages = Language::all();
        $testResult = TestResult::where('student_profile_id', $studentProfileId)->first();
        $certificates = Certificate::all();
        return view('admin.students.edit-student-wait-test', compact('languages', 'certificates', 'student', 'studentProfile', 'testResult'));
    }


    public function updateWaitTest(Request $request)
    {
        $param = $request->all();
        $studentId = $param['student_id'];
        $studentProfileId = $param['student_profile_id'];
        $studentProfile = StudentProfile::find($studentProfileId);
        $student = User::find($studentId);
        if (!$student || $student->role !== User::ROLE_STUDENT) {
            return redirect('admin/students/wait-test')->with('error', 'Học viên không tồn tại!');
        } else {
            //nếu có học viên thì cập nhật thông tin
            $student->name = $param['name'];
            $student->email = $param['email'];
            $student->phone_number = $param['phone_number'];
            $student->birthday = $param['birthday'];
            $student->save();
            $totalScore = $param['score'];
            $level = Level::where('certificate_id', $param['certificate'])
                ->where('min_score', '<=', $totalScore)
                ->where('max_score', '>=', $totalScore)
                ->first();
            
            $studentProfile->id = $studentProfileId;
            $studentProfile->current_level_id = $level->id ?? null;
            if (empty($studentProfile->current_level_id)) {
                return redirect()->back()->with('error', 'Không tìm thấy level phù hợp với điểm số.');
            }
            $studentProfile->status = StudentProfile::STATUS_WAIT_CLASS;
            $studentProfile->language_id = $param['language'];
            $studentProfile->certificate_id = $param['certificate'];
            $studentProfile->save();
            // $testResult = TestResult::where('student_id', $studentId)
            //     ->whereDate('test_date', $studentProfile->created_at)
            //     ->first();
            $testResult = TestResult::where('student_profile_id', $studentProfileId)->first();
            $testResult->result_status = TestResult::ROLE_FIRST_TEST;
            $testResult->total_score = $totalScore;
            $testResult->save();
        }
        return redirect()->back()->with('success', 'Cập nhật học viên chờ test thành công!');
    }
}
