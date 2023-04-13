<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
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
        $loginlog = new LoginLog([
            'user_id' => $event->user->id,
            'type_login' => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'login_time' => now(),
        ]);

        $loginlog->save();
    }
}
