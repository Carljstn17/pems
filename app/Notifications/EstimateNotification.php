<?php

namespace App\Notifications;

use App\Models\Estimate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstimateNotification extends Notification
{
    use Queueable;
    protected $estimate;

    /**
     * Create a new notification instance.
     */
    public function __construct(Estimate $estimate)
    {
        $this->estimate = $estimate;
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
                    ->line('This estimate ' . $this->estimate->group_id . ' is already evaluated.')
                    ->line('Evaluation status: '. $this->estimate->status)
                    ->line('Remarks: '. $this->estimate->remarks)
                    ->action('Estimate link: ', route('estimate.form', $this->estimate->group_id))                    
                    ;
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
            'group_id' => $this->estimate->id,
            // Add any other relevant information
        ];
    }
}
