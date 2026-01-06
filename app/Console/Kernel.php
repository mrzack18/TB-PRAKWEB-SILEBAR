<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CheckExpiredAuctions;
use App\Jobs\SendAuctionReminder;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        // Run the CheckExpiredAuctions job every minute
        $schedule->job(CheckExpiredAuctions::class)->everyMinute();

        // Send reminders 5 minutes before auction ends
        $schedule->job(SendAuctionReminder::class)->everyFiveMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}