<?php

namespace App\Listeners;

use App\Events\SessionExpired;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DestroyApiTokenOnSessionExpired
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
        $user = User::find($event->userId);

        if($user) {
            $user->api_token = null;
            $user->save();
        }
    }
}
