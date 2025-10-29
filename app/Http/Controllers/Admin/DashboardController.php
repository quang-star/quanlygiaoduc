<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillHistory;
use App\Models\ClassModel;
use App\Models\Contract;
use App\Models\Course;
use App\Models\Language;
use App\Models\StudentProfile;
use App\Models\TeacherSalary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        // Count sample
        $totalStudents = User::where('role', User::ROLE_STUDENT)->count();
        $totalTeachers = User::where('role', User::ROLE_TEACHER)->count();
        $totalCourses = Course::count();
        $contractInMonth = Contract::whereMonth('created_at', date('m'))->count();
        $totalRevenue = Contract::whereMonth('created_at', date('m'))->sum('collected');
        $teacherSalaries = TeacherSalary::whereMonth('created_at', date('m'))->sum('total_salary');
        $classFinished = ClassModel::where('status', ClassModel::COMPLETED)->count();
        $classRunning = ClassModel::where('status', ClassModel::RUNNING)->count();

        /* Calculate for chart */
        $years = range(date('Y') - 2, date('Y')); // 3 năm gần nhất
        $chartAreaData = [];

        foreach ($years as $year) {
            $revenue = BillHistory::select(
                DB::raw('MONTH(payment_time) as month'),
                DB::raw('SUM(money) as total')
            )
                ->whereYear('payment_time', $year)
                ->groupBy(DB::raw('MONTH(payment_time)'))
                ->orderBy(DB::raw('MONTH(payment_time)'))
                ->pluck('total', 'month')
                ->toArray();

            $monthlyRevenue = [];
            for ($m = 1; $m <= 12; $m++) {
                $monthlyRevenue[] = isset($revenue[$m]) ? round($revenue[$m] / 1000000, 2) : 0;
            }

            $chartAreaData[$year] = [
                'revenue' => $monthlyRevenue,
            ];
        }

        /* Bar chart languages */
        $languageStats = StudentProfile::select('language_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('language_id')
            ->groupBy('language_id')
            ->get();

        $chartPieLabels = [];
        $chartPieData = [];

        foreach ($languageStats as $item) {
            $language = Language::find($item->language_id);
            $chartPieLabels[] = $language ? $language->name : 'Không xác định';
            $chartPieData[] = $item->total;
        }

        /* Bar chart for course */
        $selectedMonth = $request->get('month', 'all');

        $courses = Course::pluck('name', 'id')->toArray();

        $chartSalesLabels = array_values($courses); // tên khóa học
        $chartSalesData   = []; // dữ liệu doanh số (triệu đồng)

        if ($selectedMonth === 'all') {
            // === Tổng doanh thu từ hợp đồng ===
            $contractStats = Contract::select('course_id', DB::raw('SUM(collected) as total'))
                ->whereNotNull('course_id')
                ->groupBy('course_id')
                ->pluck('total', 'course_id')
                ->toArray();

            foreach ($courses as $courseId => $courseName) {
                $chartSalesData[] = isset($contractStats[$courseId])
                    ? round($contractStats[$courseId] / 1000000, 2) // triệu đồng
                    : 0;
            }
        } else {
            // === Doanh thu theo tháng từ BillHistory ===
            $billStats = BillHistory::select('contracts.course_id', DB::raw('SUM(bill_histories.money) as total'))
                ->join('contracts', 'contracts.id', '=', 'bill_histories.contract_id')
                ->whereMonth('bill_histories.payment_time', $selectedMonth)
                ->groupBy('contracts.course_id')
                ->pluck('total', 'contracts.course_id')
                ->toArray();

            foreach ($courses as $courseId => $courseName) {
                $chartSalesData[] = isset($billStats[$courseId])
                    ? round($billStats[$courseId] / 1000000, 2)
                    : 0;
            }
        }

        return view('admin.dashboard.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalCourses',
            'contractInMonth',
            'totalRevenue',
            'teacherSalaries',
            'classFinished',
            'classRunning',
            'chartAreaData',
            'years',
            'chartPieLabels',
            'chartPieData',
            'chartSalesLabels',
            'chartSalesData',
            'selectedMonth'
        ));
    }
}
