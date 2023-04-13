<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountVerifier extends Mailable
{
    use Queueable, SerializesModels;

    private $emailToken;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailToken)
    {
        $this->emailToken = $emailToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify-email')->with(['token' => $this->emailToken]);
    }
}
