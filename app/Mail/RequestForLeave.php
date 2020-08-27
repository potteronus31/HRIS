<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestForLeave extends Mailable
{
    use Queueable, SerializesModels;

   public $getfname, $getlname, $daterange, $purpose, $getleavetypename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getfname, $getlname, $daterange, $purpose, $getleavetypename)
    {
        //
        $this->getfname = $getfname;
        $this->getlname = $getlname;
        $this->daterange = $daterange;
        $this->purpose = $purpose;
        $this->getleavetypename = $getleavetypename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.requestforleave');
    }
}
