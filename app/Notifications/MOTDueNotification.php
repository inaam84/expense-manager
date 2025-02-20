<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MOTDueNotification extends Notification
{
    use Queueable;

    protected $vehicle;

    /**
     * Create a new notification instance.
     */
    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('MOT Due Soon')
                    ->line("Your vehicle ({$this->vehicle->registration_number}) MOT is due on {$this->vehicle->mot_due_date->format('d/m/Y')}.")
                    ->action('Check Details', url('/vehicles'))
                    ->line('Please make sure to renew it in time.');
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
}
