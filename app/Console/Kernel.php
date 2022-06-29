<?php

namespace App\Console;

use App\Jobs\DisableExpiredAdvertisement;
use App\Jobs\SendAdvertisementExpirationNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->job(new DisableExpiredAdvertisement())
            ->dailyAt('23:00');

        $schedule->job(new SendAdvertisementExpirationNotification())
            ->dailyAt('10:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
