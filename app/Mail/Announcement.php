<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Announcement extends Mailable
{
    use Queueable, SerializesModels;
    public $getid, $gettitle, $getdescription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getid, $getdescription, $gettitle)
    {
        //
        $this->getid = $getid;
        $this->gettitle = $gettitle;
        $this->getdescription = $getdescription;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.announcement');
    }
}
