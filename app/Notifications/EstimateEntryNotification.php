<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EstimateEntryNotification extends Notification
{
    use Queueable;
    public $estimates;

    /**
     * Create a new notification instance.
     */
    public function __construct($estimates)
    {
        $this->estimates = $estimates;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */  

    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Estimate Entry')
            ->markdown('emails.estimate_entry_notification', [
                'status' => ucfirst($this->estimates->first()->status),
                'entryId' => $this->estimates->first()->group_id,
                'entryBy' => $this->estimates->first()->user->username,
                'entryDate' => $this->estimates->first()->created_at->format('Y-m-d'),
                'estimates' => $this->estimates,
                'remarks' => $this->estimates->first()->remarks,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'group_id' => $this->estimates->first()->group_id,
            // Add any other relevant information
        ];
    }
}
