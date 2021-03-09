<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\SwaggerScan',
        'App\Console\Commands\getECLIsfromJuportal',
        'App\Console\Commands\indexDocument',
        'App\Console\Commands\getContentfromJuportal',
        'App\Console\Commands\anonContent',
        'App\Console\Commands\checkLanguage',
        'App\Console\Commands\findDuplicates'
        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
