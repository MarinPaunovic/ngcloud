<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $schedule->call(function () {
            $tokens = DB::table('password_resets')->get();
            foreach ($tokens as $token) {
                $timestrCurrent = Carbon::now();
                $timePassed = strtotime($timestrCurrent) - strtotime($token->created_at);
                if ((int) date('i', $timePassed) > 1) {
                    DB::table('password_resets')
                        ->where('email', '=', $token->email)
                        ->delete();
                }
            }
        })->everyMinute();
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
