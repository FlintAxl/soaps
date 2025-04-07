<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Make sure to import your User model

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // This makes $user available to your view

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to Soap Haven!')
                   ->view('emails.welcome'); // Points to resources/views/emails/welcome.blade.php
    }
}
