<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Http\Request;


class FlokzuController extends Controller
{
    public function respuestaFlokzu(Request $request)
    {
        $data = $request->all();

        dd($data);

        return response()->json([
            'data' => $data,
        ]);
    }
}
