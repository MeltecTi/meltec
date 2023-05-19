<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    /**
     * Envio de Mensajes y recibidor de respuesta
     * @param <int|string> $phoneto = Numero telefonico del cliente a contactar 
     * @param $template <Object> = Template a usar para el primer contacto con el cliente  
     * 
     * @return <Object> Json
     */
    public function sendMessages()
    {
        try {
            $token = env('WHATSAPP_TOKEN_API');

            $phoneId = '119322754488743';
            $version = 'v15.0';

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => '+573132803746',
                'type' => 'template',
                'template' => [
                    'name' => 'hello_world',
                    'language' => [
                        'code' => 'en_US',
                    ],
                ],
            ];

            $message = Http::withToken($token)->post('https://graph.facebook.com/' . $version . '/' . $phoneId . '/messages', $payload)->throw()->json();

            return response()->json([
                'success' => true,
                'data' => $message,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Webhook Facebook
     * 
     * @return <void> : Verificacion de webhook de Facebook
     * 
     */

    public function webhookWhatsapp(Request $request)
    {
        try {
            $token = env('VERIFY_TOKEN');
            $query = $request->query();

            $mode = $query['hub_mode'];
            $challenge = $query['hub_challenge'];
            $verifyToken = $query['hub_verify_token'];

            if ($mode && $verifyToken) {
                if ($mode === 'subscribe' && $token === $verifyToken) {
                    return response($challenge, 200)->header('Content-Type', 'text/plain');
                }

                throw new Exception('Invalid Request');
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function processWebhook(Request $request)
    {
        try {

            $body = json_decode($request->getContent(), true);
            $message = '';

            // Determinar que se envio
            $value = $body['entry'][0]['changes'][0]['value'];

            if (!empty($value['messages'][0])) {
                if ($value['messages'][0]['type'] === 'text') {
                    $message = $value['messages'][0]['text']['body'];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $message,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
