<?php

namespace App\Console;

use App\Models\Ticket;
use App\Models\Setting;
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
        $schedule->call(function(){
           $tickets = Ticket::all();
           $availableVisitsNumber = Setting::whereName('visitsNumber')->first()->value;
           foreach ($tickets as $ticket){
               if(count($ticket?->visitsWithoutMisses) >= $availableVisitsNumber AND $ticket?->paused !== true
                       OR $ticket?->end_date < today() AND $ticket?->paused !== true) {
                   $ticket->update(['is_closed' => 1]);
               };
           }
        })->daily();
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
