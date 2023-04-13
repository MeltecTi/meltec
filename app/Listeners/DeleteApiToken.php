<?php

namespace App\Listeners;

use App\Events\SessionExpired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class DeleteApiToken
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
    public function handle(SessionExpired $event): void
    {
        $event->user->api_token = null;
        $event->user->save();
    }
}
