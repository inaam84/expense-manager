<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewUserCreatedEvent;
use App\Events\TicketCreatedEvent;
use App\Events\TicketUpdatedByAgentEvent;
use App\Listeners\AccountContact\SendTicketCreatedEmailToAccountContactListener;
use App\Listeners\AccountContact\SendTicketUpdatedEmailToAccountContactListener;
use App\Listeners\Auth\FailedLoginListener;
use App\Listeners\Auth\LoginListener;
use App\Listeners\Auth\LogoutListener;
use App\Listeners\Auth\NewUserCreatedListener;
use App\Listeners\Auth\OtherDeviceLogoutListener;
use App\Listeners\Auth\PasswordResetListener;
use App\Listeners\Users\SendTicketRaisedListener;
use App\Models\Ticket;
use App\Observers\TicketObserver;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\PasswordReset;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LoginListener::class,
        ],
        Logout::class => [
            LogoutListener::class,
        ],
        Failed::class => [
            FailedLoginListener::class,
        ],
        OtherDeviceLogout::class => [
            OtherDeviceLogoutListener::class,
        ],
        NewUserCreatedEvent::class => [
            NewUserCreatedListener::class,
        ],
        PasswordReset::class => [
            PasswordResetListener::class,
        ],
        TicketCreatedEvent::class => [
            SendTicketCreatedEmailToAccountContactListener::class,
            SendTicketRaisedListener::class,
        ],
        TicketUpdatedByAgentEvent::class => [
            SendTicketUpdatedEmailToAccountContactListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Ticket::observe(TicketObserver::class);
    }
}
