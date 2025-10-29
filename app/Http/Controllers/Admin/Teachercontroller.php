<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TeacherSalaryExport;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\TeacherSalary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Teachercontroller extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::where('role', User::ROLE_TEACHER)
            ->with('bankAccount')
            ->get();
        //dd($teachers);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function addTeacherIndex()
    {
        return view('admin.teachers.add');
    }

    public function addTeacher(Request $request)
    {
        $param = $request->all();
        $teacher = User::where('email', $param['email'])->first();
        if ($teacher) {
            return redirect()->back()->with('error', 'Email nây đa Giảng viên');
        }
        $teacher = User::create([
            'name' => $param['name'],
            'email' => $param['email'],
            'phone_number' => $param['phone'],
            'birthday' => $param['birthday'],
            'password' => bcrypt('123456'),
            'base_salary' => $param['base_salary'],
            'role' => User::ROLE_TEACHER,
            'active' => $param['status']
        ]);
        // kiểm tra tài khoản ngân hàng, có thì update chưa có thì tạo mới
        $bankAccount = BankAccount::where('user_id', $teacher->id)->first();
        if ($bankAccount) {
            $bankAccount->update([
                'user_id' => $teacher->id,
                'bank' => $param['bank_name'],
                'account_number' => $param['bank_account'],
            ]);
        } else {
            BankAccount::create([
                'user_id' => $teacher->id,
                'bank' => $param['bank_name'],
                'account_number' => $param['bank_account'],
            ]);
        }
        return redirect('/admin/teachers/index')->with('success', 'Them giảng viên thanh cong');
    }


    public function updateTeacherIndex(Request $request, $teacherId)
    {
        $param = $request->all();
        $teacher = User::with('bankAccount')->find($teacherId);

        // 1️ Số buổi dạy theo tháng
        $classes = DB::table('classes')
            ->where('teacher_id', $teacherId)
            ->select('id', 'day_learn', 'start_date')
            ->get();

        $teachingData = [];
        $classData = [];
        // xử lý số buổi dạy theo tháng
        foreach ($classes as $class) {
            // Tách từng ngày học
            $days = array_filter(explode(',', $class->day_learn));
            foreach ($days as $day) {
                $month = \Carbon\Carbon::parse($day)->format('Y-m');
                // Đếm tổng số buổi học trong tháng
                if (!isset($teachingData[$month])) {
                    $teachingData[$month] = 0;
                }
                $teachingData[$month]++;
                // Ghi nhận lớp trong tháng (mỗi lớp chỉ tính 1 lần / tháng)
                if (!isset($classData[$month])) {
                    $classData[$month] = [];
                }
                $classData[$month][$class->id] = true;
            }
        }
        // Đếm số lớp theo tháng
        foreach ($classData as $month => $classesInMonth) {
            $classData[$month] = count($classesInMonth);
        }
        // Sắp xếp tăng dần theo tháng
        ksort($teachingData);
        ksort($classData);
        // Giới hạn 12 tháng gần nhất
        if (count($teachingData) > 12) {
            $teachingData = array_slice($teachingData, -12, 12, true);
        }
        if (count($classData) > 12) {
            $classData = array_slice($classData, -12, 12, true);
        }
        // 2️ Lương theo tháng
        $salaryData = DB::table('teacher_salaries')
            ->select('month', 'total_salary')
            ->where('teacher_id', $teacherId)
            ->orderBy('month')
            ->pluck('total_salary', 'month')
            ->toArray();
        // Giới hạn 12 tháng gần nhất cho lương
        if (count($salaryData) > 12) {
            $salaryData = array_slice($salaryData, -12, 12, true);
        }
        return view('admin.teachers.edit', compact('teacher', 'teachingData', 'classData', 'salaryData'));
    }



    public function updateTeacher(Request $request)
    {
        $param = $request->all();
        $teacherId = $param['teacher_id'];
        $teacher = User::find($teacherId);
        $teacher->update([
            'name' => $param['name'],
            'email' => $param['email'],
            'phone_number' => $param['phone'],
            'birthday' => $param['birthday'],
            'active' => $param['status']

        ]);
        return redirect()->back()->with('success', 'Cap nhat giảng viên thanh cong');
    }

    public function deleteTeacher(Request $request)
    {
        $param = $request->all();
        $teacherId = $param['teacher_id'];
        $teacher = User::find($teacherId);
        if ($teacher) {
            $teacher->delete();
        } else {
            return redirect()->back()->with('error', 'Giảng viên khong ton tai');
        }
        return redirect()->back()->with('success', 'Xoá giảng viên thanh cong');
    }

    public function salaryIndex(Request $request)
    {
        $month = request('month') ?? now()->format('Y-m');
        $salaries = TeacherSalary::with('teacher')
            ->where('month', $month)
            ->get();

        return view('admin.teachers.salary', compact('salaries', 'month'));
    }

    public function exportSalary(Request $request)
    {
        $ids = json_decode($request->selected_ids, true) ?? [];
        $month = $request->month ?? now()->format('Y-m');

        TeacherSalary::whereIn('id', $ids)->update([
            'status' => TeacherSalary::STATUS_EXPORTED
        ]);

        // Lưu file tạm trong storage/app/public
        $fileName = "Luong_GiangVien_$month.xlsx";
        Excel::store(new TeacherSalaryExport($ids, $month), $fileName, 'public');

        // Redirect về trang trước kèm thông báo
        return redirect()->back()->with('success', 'Xuất file thành công. File: ' . $fileName);
    }
}
