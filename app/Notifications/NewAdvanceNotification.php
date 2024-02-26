<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\AdvanceRequest;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewAdvanceNotification extends Notification
{
    use Queueable;
    protected $advanceRequest;
    /**
     * Create a new notification instance.
     */
    public function __construct(AdvanceRequest $advanceRequest)
    {
        $this->advanceRequest = $advanceRequest;
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
        $user = User::findOrFail($this->advanceRequest->entry_by);
        
        return (new MailMessage)
        ->line('You have a new advance request:')
        ->line('- Submitted by: ' . $user->name)
        ->line('- Amount: $' . $this->advanceRequest->amount)
        ->line('- Reason of Request: ' . $this->advanceRequest->id)
        ->action('View Advance Request', route('request.notif', $this->advanceRequest->id));
    }

    /**
     * Get the array representation of the notification.
     * @param
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
            'advance_id' => $this->advanceRequest->id,
            // Add any other relevant information
        ];
    }
}
