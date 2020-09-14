<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubmitApplication extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    public $getappname, $getjobname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=[], $getappname, $getjobname)
    {
        //
         $this->data = $data;
         $this->getappname = $getappname;
         $this->getjobname = $getjobname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $path = "https://hris.livewire365.com/uploads/applicantResume";
        $name = $this->data['getfilename'];
        
        return  $this->markdown('emails.submitapplication')
                ->from($this->data['fromadd'])
                ->subject('Job Application')
                ->attach($path ."/". $name,
                [
                    'as' => $this->data['file']->getClientOriginalName(),
                    'mime' => $this->data['file']->getClientMimeType(),
                ]);
    }
}
