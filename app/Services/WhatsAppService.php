<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;

class WhatsAppService
{
    protected $client;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp.url');
        $this->token = config('services.whatsapp.token');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function sendMessage($to, $message)
    {
        $response = $this->client->post('', [
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function initialMessage($to, $message)
    {
        $response = $this->client->post('', [
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => 'hell_world',
                    'code' => 'en_US'
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function returnMessage()
    {
        $response = $this->client->post('', [
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => 54261152797321,
                'type' => 'template',
                'template' => [
                    'name' => 'hell_world',
                    'code' => 'en_US'
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
