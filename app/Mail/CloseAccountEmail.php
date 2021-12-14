<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CloseAccountEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($auser)
    {
        $this->user = $auser;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        

        return  $this->subject('Profile Deleted')->markdown('emails.close_account')->with([
            'name' => $this->user->name,
        ]);
    }
}
