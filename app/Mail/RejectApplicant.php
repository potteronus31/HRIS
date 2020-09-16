<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectApplicant extends Mailable
{
    use Queueable, SerializesModels;

    public $getname, $getjobtitle;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getname, $getjobtitle)
    {
        //
        $this->getname = $getname;
        $this->getjobtitle = $getjobtitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.rejectapp');
    }
}
