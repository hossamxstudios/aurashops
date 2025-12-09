<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // May be removed if BaseVerifyEmail handles ShouldQueue
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmailNotification extends BaseVerifyEmail
{
    // We can remove Queueable if inheriting from BaseVerifyEmail which might handle it,
    // or keep if we want specific queue behavior for this notification.
    // For now, let's assume BaseVerifyEmail handles queueing if necessary.

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
        ->subject('Verify Email Address')
        ->markdown('emails.custom-verify-email', ['url' => $verificationUrl, 'user' => $notifiable]);
    }

    // We can remove the via() and toArray() methods if we are satisfied
    // with the parent's implementation or if they are not needed.
    // BaseVerifyEmail likely defines via() as ['mail'].
}

