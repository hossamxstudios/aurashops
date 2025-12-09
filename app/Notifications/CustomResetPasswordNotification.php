<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Support\Facades\Lang;

class CustomResetPasswordNotification extends BaseResetPassword
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
        $this->token = $token;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            // Default URL construction if no callback is set
            // This needs to match how your password reset routes are defined
            // e.g., route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()])
            // For Breeze, it's typically like this:
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->markdown('emails.custom-reset-password', ['url' => $url, 'user' => $notifiable, 'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]);
    }

    // The via() and toArray() methods can typically be inherited from BaseResetPassword
    // or removed if not needed for specific customization.
}

