<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageWhatsAppRequest;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function initialMessage(Request $request)
    {
        $to = $request->input('to');

        $response = $this->whatsappService->initialMessage($to);

        return response()->json($response);
    }

    public function sendMessage(SendMessageWhatsAppRequest $request)
    {
        $to = $request->input('to');
        $message = $request->input('message');

        $response = $this->whatsappService->sendMessage($to, $message);

        return response()->json($response);
    }

    public function returnMessage(Request $request)
    {
        $response = $this->whatsappService->returnMessage();

        return response()->json($response);
    }

    public function verify(Request $request)
    {
        $mode = $request->query('hub.mode');
        $token = $request->query('hub.verify_token');
        $challenge = $request->query('hub.challenge');

        if ($mode && $token === 'startletApi123!') {
            return response($challenge, 200);
        } else {
            return response('Verification failed', 403);
        }
    }
}
