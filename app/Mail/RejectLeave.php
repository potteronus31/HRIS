<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectLeave extends Mailable
{
    use Queueable, SerializesModels;
    public $getdatenow, $getdatefrom, $getdateto, $getpurpose, $getleavetypename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getdatenow, $getpurpose, $getdatefrom, $getdateto, $getleavetypename)
    {
        //
        $this->getdatenow = $getdatenow;
        $this->getpurpose = $getpurpose;
        $this->getdatefrom = $getdatefrom;
        $this->getdateto = $getdateto;
        $this->getleavetypename = $getleavetypename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.rejectleave');
    }
}
