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

    public function templateMessage(Request $request)
    {
        $to = $request->input('to');

        $response = $this->whatsappService->templateMessage($to);

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

    public function verifyWebhook(Request $request)
    {
        $allParams = $request->all();

        $mode = $allParams['hub_mode'] ?? null;
        $token = $allParams['hub_verify_token'] ?? null;
        $challenge = $allParams['hub_challenge'] ?? null;

        if ($mode && $token === 'startletApi123!') {
            return response($challenge, 200);
        } else {
            return response('Verification failed', 403);
        }
    }

    public function automaticResponse(Request $request)
    {
        $bodyContent = json_decode($request->getContent(), true);
        $message = $bodyContent['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        $phoneString = $bodyContent['entry'][0]['changes'][0]['value']['messages'][0]['from'];
        $numberString = $bodyContent['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];

        $phone = (int) $phoneString;
        $number = (int) $numberString;

        $bodyString = json_encode($bodyContent);

        if ($number == 54261152797321) {
            $this->whatsappService->sendMessage($number, $bodyString);
            $response = $number;
        } else {
            $this->whatsappService->sendMessage(54261152797321, $bodyString);
            $response = $phone;
        }

        return response()->json(['success' => true, 'data' => $response], 200);
    }
}
