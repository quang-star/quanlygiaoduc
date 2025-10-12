<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // $students = User::where('role', User::ROLE_STUDENT)
        //     ->with([
        //         'testResults', 

        //         'studentProfile.level', 
        //         'contracts.course',
        //         'contracts.class'
        //     ])
        //     ->get();
        // dd($students);
        $students = DB::table('users')->where('role', User::ROLE_STUDENT)
            ->join('student_profiles', 'users.id', '=', 'student_profiles.student_id')
            ->join('levels', 'users.id', '=', 'levels.id')
            ->join('courses', 'student_profiles.current_level_id', '=', 'courses.level_id')
            ->leftJoin('contracts', function ($join) {
                $join->on('users.id', '=', 'contracts.student_id')
                    ->on('contracts.course_id', '=', 'courses.id');
            })
            ->leftJoin('classes', 'classes.id', '=', 'contracts.class_id')

            // ->select('users.id', 'users.name', 'users.email', 'users.phone_number', 
            // 'levels.name as level_name',  
            // 'courses.name as course_name', 
            // 'student_profiles.status')
            ->select('users.id', 'users.name', 'users.email', 'users.phone_number', 'levels.name as level_name', 'classes.name as class_name', 'courses.name as course_name', 'student_profiles.status')
            ->get();
        dd($students);
        $student_list = array_count_values($students->pluck('id')->toArray());
        //
        //dd($student_list);
        foreach ($students as $student) {
            // if(in_array($student->id, $student_list[$student->id])){
            //     $student_list[]
            // }
            //dd($student, $student_list);
            $student->rowspan = $student_list[$student->id];
        }





        return view('admin.students.student', compact('students'));
    }
}
