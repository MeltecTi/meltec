<?php

namespace App\Observers;

use App\Models\LoginLog;

class LoginLogObserver
{
    public function created(LoginLog $loginLog)
    {
        // lógica a ejecutar cuando se crea un registro en LoginLog
    }
}