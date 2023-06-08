<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Socialite\Facades\Socialite;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleApiController extends Controller
{
    public function loginGoogle()
    {
        $user = Socialite::driver('google')->scopes(['offline'])->user();
        $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

        if (!$userExists) {
            $userNew = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'image' => $user->avatar,
                'external_id' => $user->id,
                'external_auth' => 'google',
                'google_access_token' => $user->token,
                'google_refresh_token' => $user->refreshToken,
            ]);

            $userNew->assignRole(1);
            $token = JWTAuth::fromUser($userNew);

            $userNew->api_token = $token;
            $userNew->save();

            Auth::login($userNew);
            return redirect('/home');
        }

        $userExists->google_access_token = $user->token;
        $userExists->google_refresh_token  = $user->refreshToken;

        $token = JWTAuth::fromUser($userExists);
        $userExists->api_token = $token;

        $userExists->save();

        Auth::login($userExists);

        return redirect('/home');
    }

    public function prueba(Request $request)
    {
        
        $client = new Client();
        $client->setAuthConfig(config('services.google.client_secret2'));
        $client->addScope(Calendar::CALENDAR);
        
        $accessToken = auth()->user()->google_access_token;
        
        $client->setAccessToken($accessToken);

        if($client->isAccessTokenExpired()){
            return response()->redirect('/login-google');
        }
        
        $calendarServices = new Calendar($client);
        
        $event = new Event([
            'summary' => 'Título del evento',
            'description' => 'Descripción del evento',
            'start' => [
                'dateTime' => '2023-05-26T10:00:00',
                'timeZone' => 'America/New_York',
            ],
            'end' => [
                'dateTime' => '2023-05-26T12:00:00',
                'timeZone' => 'America/New_York',
            ],
        ]);

        // // Opcional: Añade invitados al evento
        // $event->setAttendees([
        //     ['email' => 'correo1@example.com'],
        //     ['email' => 'correo2@example.com'],
        // ]);


        $eventCreate = $calendarServices->events->insert('primary', $event);

        return response()->json([
            // 'data' => $request->all(),
            'data' => $eventCreate,
        ]);
    }
}
