<?php

namespace App\Providers;

use App\Events\SessionExpired;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;

use App\Listeners\DestroyApiToken;
use App\Listeners\DestroyApiTokenOnLockOut;
use App\Listeners\GenerateApiToken;
use App\Listeners\DeleteApiToken;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // Login::class => [
        //     GenerateApiToken::class,
        //     LogSuccessfulLogin::class,
        // ],
        // Logout::class => [
        //     DestroyApiToken::class,
        //     LogSuccessfulLogout::class,
        // ],
        // Lockout::class => [
        //     DestroyApiTokenOnLockOut::class,
        // ],
        // SessionExpired::class => [
        //     DeleteApiToken::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

