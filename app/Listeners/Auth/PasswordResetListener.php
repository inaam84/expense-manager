<?php

namespace App\Listeners\Auth;

use App\Mail\Auth\PasswordResetEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PasswordResetListener
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user->email)
            ->send(new PasswordResetEmail($event->user));
    }
}
