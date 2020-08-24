<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Repositories\LeaveRepository;
use App\Model\LeaveApplication;
use App\Model\Employee;


class LeaveRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $supervisorid;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LeaveApplication $uspervisorid)
    {
        //
        // $this->leaveappid = $leaveappid;
        $this->supervisorid = $supervisorid;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
