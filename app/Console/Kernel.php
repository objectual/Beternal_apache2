<?php

namespace App\Console;

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
        $schedule->command('delivery:cron')->everyFiveMinutes();
        $schedule->command('loginstatus:notification')->everyFiveMinutes();
        $schedule->command('login:statusemail')->hourly();
        $schedule->command('email:firstcontact')->hourly();
        // $schedule->command('email:secondcontact')->hourly();
        // $schedule->command('email:thirdcontact')->hourly();
        // $schedule->command('delivery:legacy')->hourly();
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
