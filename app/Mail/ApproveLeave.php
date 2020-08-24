<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveLeave extends Mailable
{
    use Queueable, SerializesModels;
    public $getdatenow, $getpurpose, $getdatefrom, $getdateto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getdatenow, $getpurpose, $getdatefrom, $getdateto)
    {
        //
        $this->getdatenow = $getdatenow;
        $this->getpurpose = $getpurpose;
        $this->getdatefrom = $getdateto;
        $this->getdateto = $getdateto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.approveleave');
    }
}