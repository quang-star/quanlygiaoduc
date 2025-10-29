<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Course;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentWaitClassController extends Controller
{
    public function waitClass(Request $request)
    {
        $students = DB::table('users')->where('role', User::ROLE_STUDENT)
            ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
            ->leftJoin('levels', 'student_profiles.current_level_id', '=', 'levels.id')
            ->join('courses', 'student_profiles.current_level_id', '=', 'courses.level_id')
            ->leftJoin('contracts', function ($join) {
                $join->on('student_profiles.id', '=', 'contracts.student_profile_id')
                    ->on('contracts.course_id', '=', 'courses.id');
            })
            ->where('student_profiles.status', StudentProfile::STATUS_WAIT_CLASS) // Đổi sang status chờ lớp

            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone_number',
                'student_profiles.id as student_profile_id',
                'student_profiles.status as student_status',
                'student_profiles.created_at as register_date',
                'courses.name as course_name',
                'courses.id as course_id',
                'levels.name as level_name',
                'contracts.id as contract_id'
            )
            ->orderBy('users.id', 'desc')
            ->distinct();
            $datas = [];
        if ($request->filled('course')) {
            $datas['course'] = $request->course;
            $students->where('courses.name', 'like', '%' . $request->course . '%');
        }

        $students = $students->get();

        //dd($students);
        $classes = DB::table('classes')->get()->groupBy('course_id');

        //dd($students);
        return view('admin.students.student-wait-class', compact('students', 'classes', 'datas'));
    }


    public function saveWaitClass(Request $request)
    {
        $param = $request->all();
        // dd($param);
        try {
            $studentProfile = StudentProfile::find($param['student_profile_id']);
            $studentProfile->update([
                'class_id' => $param['class_id'],
                'status' => StudentProfile::STATUS_LEARNING,

            ]);
            $studentId = $studentProfile->student_id;

            // $studentProfile->status = StudentProfile::STATUS_LEARNING; // Cập nhật trạng thái sang "Đang học"
            // $studentProfile->save();
            $course = Course::with('level')->where('level_id', $studentProfile->current_level_id)->first();
            // Cập nhật bảng contracts
            $contract = Contract::where('student_profile_id', $studentProfile->id)
                ->where('course_id', $course->id)
                ->first();

            $contract->class_id = $param['class_id'];
            $contract->save();


            return redirect()->back()->with('success', 'Cập nhật trạng thái học viên thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái học viên: ' . $e->getMessage());
        }
    }
}
