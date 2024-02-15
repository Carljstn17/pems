<?php

namespace App\Notifications;

use App\Models\Concern;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewConcernNotification extends Notification
{
    use Queueable;
    protected $concern;
    /**
     * Create a new notification instance.
     */
    public function __construct(Concern $concern)
    {
        $this->concern = $concern;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('You have a new concern of laborer:')
        ->line('- Concern: ' . $this->concern);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

     public function toDatabase($notifiable)
    {
        return [
            'concern_id' => $this->concern->id,
            // Add other data as needed
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}