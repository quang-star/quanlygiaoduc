<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\TeacherSalary;
use Carbon\Carbon;

class CalculateTeacherSalary extends Command
{
    protected $signature = 'salary:calculate {month?}';
    protected $description = 'Tính lương giáo viên cho tháng được chỉ định hoặc tháng hiện tại';

    public function handle()
    {
        // Xác định tháng cần tính lương
        $month = $this->argument('month') ?? Carbon::now()->format('Y-m');
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // Lấy tất cả giáo viên active + eager load classes
        $teachers = User::where('role', User::ROLE_TEACHER)
            ->where('active', User::ACTIVE)
            ->with('classesTeaching', 'bankAccount')
            ->get();

        foreach ($teachers as $teacher) {
            $total_sessions = 0;
           
            // Lặp qua tất cả lớp
            foreach ($teacher->classesTeaching as $class) {
                $days = explode(',', $class->day_learn); // tách chuỗi ngày ra mảng
                foreach ($days as $day) {
                    $day = trim($day); // loại bỏ khoảng trắng
                    if ($day >= $startDate->format('Y-m-d') && $day <= $endDate->format('Y-m-d')) {
                        $total_sessions++;
                    }
                }
            }

            // Lấy lương cơ bản
            $base_salary = $teacher->base_salary;

            // Tính bonus theo số buổi
            if ($total_sessions >= 20) {
                $bonus = $total_sessions * $base_salary * 0.1;
            } elseif ($total_sessions >= 10) {
                $bonus = $total_sessions * $base_salary * 0.05;
            } else {
                $bonus = 0;
            }

            $penalty = 0;
            $total_salary = $total_sessions * $base_salary + $bonus - $penalty;

            // Lưu hoặc cập nhật bảng teacher_salaries
            TeacherSalary::updateOrCreate(
                ['teacher_id' => $teacher->id, 'month' => $month],
                [
                    'total_sessions' => $total_sessions,
                    'base_salary' => $base_salary,
                    'bonus' => $bonus,
                    'penalty' => $penalty,
                    'total_salary' => $total_salary,
                    'status' => TeacherSalary::STATUS_CALCULATED,
                    'bank_name' => $teacher->bankAccount->bank ?? '',
                    'account_number' => $teacher->bankAccount->account_number ?? '',
                ]
            );

            $this->info("Đã tính lương cho {$teacher->name}: $total_salary VNĐ");
        }

        $this->info("Hoàn tất tính lương tháng $month");
    }
}
