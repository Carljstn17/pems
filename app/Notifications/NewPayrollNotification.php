<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\PayrollBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPayrollNotification extends Notification
{
    use Queueable;

    protected $payrollBatch;

    /**
     * Create a new notification instance.
     */
    public function __construct(PayrollBatch $payrollBatch)
    {
        $this->batch = $payrollBatch;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A new payroll batch has been added.')
            ->line('Batch ID: ' . $this->batch->id)
            ->action('View Payroll Batch', route('owner.showPayroll', ['batchId' => $this->batch->id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'batch_id' => $this->batch->id,
            // Add any other relevant information
        ];
    }
}
