<?php

namespace App\Notifications\Auth;

use App\Models\Auth\AuthenticationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FailedLoginNotification extends Notification
{
    use Queueable;

    public AuthenticationLog $authenticationLog;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AuthenticationLog $authenticationLog)
    {
        $this->authenticationLog = $authenticationLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('A failed login attempt to your account.'))
                    ->markdown('emails.auth.failed-login', [
                        'account' => $notifiable,
                        'time' => $this->authenticationLog->login_at,
                        'ipAddress' => $this->authenticationLog->ip_address,
                        'browser' => $this->authenticationLog->user_agent,
                        'location' => $this->authenticationLog->location,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
