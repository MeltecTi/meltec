<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateApiToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $event->user->api_token = bin2hex(random_bytes(75));
        $event->user->save();
    }
}
