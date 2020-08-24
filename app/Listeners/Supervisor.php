<?php

namespace App\Listeners;

use App\Events\LeaveRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Announcement;
use Mail;
use DB;

class Supervisor
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeaveRequest  $event
     * @return void
     */
    public function handle(LeaveRequest $event)
    {
        
        $getsupervisorid = $event->supervisorid;
        
        $getemail = DB::table('employee')->where('supervisor_id', $getsupervisorid)->value('email');
         
        Mail::to($getemail)->send(new Announcement());
        
        //
    }
}
