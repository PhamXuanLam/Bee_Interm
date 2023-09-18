<?php

namespace App\Console;

use App\Service\ProductService;
use App\Service\UserService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('email:send-product-notification')
            ->dailyAt('8:00');
        $schedule->command('email:send-order-notification')
            ->monthlyOn(1, '20:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
