<?php

namespace App\Listeners\Auth;

use App\Mail\Auth\NewUserPasswordEmail;
use App\Mail\Auth\NewUserWelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NewUserCreatedListener
{
    public $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
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
        // send welcome email to the new user
        Mail::to($event->user->email)
            ->send(new NewUserWelcomeEmail($event->user));

        // send password email to the new user in a separate email
        Mail::to($event->user->email)
            ->later(now()->addSeconds(30), new NewUserPasswordEmail($event->user, $event->password));
    }
}
