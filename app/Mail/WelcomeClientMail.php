<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(Client $client, $password)
    {
        $this->client = $client;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to ' . config('app.name'))
                    ->view('emails.welcome-client');
    }
}
