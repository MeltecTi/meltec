<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LogoutService extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->user()->id);

        $user->api_token = '';
        $user->save();

        Auth::logout();

        return redirect('/');
    }
}
