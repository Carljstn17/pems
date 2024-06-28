<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reset Your Password')
                    ->line('Use the following OTP to reset your password:')
                    ->line($this->otp)
                    ->line('If you did not request this, please ignore this email.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
