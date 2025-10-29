<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // Chạy command vào ngày 1 mỗi tháng lúc 00:00
        $schedule->command('salary:calculate')->monthlyOn(1, '00:00');

        // Nếu muốn chạy hàng ngày (ví dụ kiểm tra số buổi mới cập nhật)
        // $schedule->command('salary:calculate')->dailyAt('01:00');

        // cách chạy nhanh
        // php artisan salary:calculate

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
