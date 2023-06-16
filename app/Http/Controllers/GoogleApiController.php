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
            $accessToken = $userNew->createToken('google-auth')->plainTextToken;

            $userNew->api_token = $accessToken;
            $userNew->save();

            Auth::login($userNew);
            return redirect('/home');
        }

        $userExists->google_access_token = $user->token;
        $userExists->google_refresh_token  = $user->refreshToken;

        $accessToken = $userExists->createToken('google-auth')->plainTextToken;
        $userExists->api_token = $accessToken;

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

        if ($client->isAccessTokenExpired()) {
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

    public function createCalendarEvent()
    {
        $client = new Client();

        $client->setClientId(env('GOOGLE_ID'));
        $client->setClientSecret(env('GOOGLE_KEY_PRIV_OAUTH'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');

        $accessToken = auth()->user()->google_access_token;

        $client->setAccessToken($accessToken);

        $calendarServices = new Calendar($client);

        $event = new Event([
            'summary' => 'Evento de Prueba',
            'start' => [
                'dateTime' => '2023-06-13T12:30:00',
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => '2023-06-13T13:30:00',
                'timeZone' => 'America/Los_Angeles',
            ],
        ]);

        $createEvent = $calendarServices->events->insert('primary', $event);

        if(!$createEvent) {
            return response()->json([
                'success' => false,
                'error' => 'Error al crear el evento',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Evento Creado',
        ]);
    }
}
