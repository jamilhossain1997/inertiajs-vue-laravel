<?php

namespace App\Services\SMS\Providers;

use Illuminate\Support\Facades\Http;

class InfobipProvider
{
    public function send($phone, $message): bool {
    
        $baseUrl = rtrim(config('services.infobip.base_url'), '/');
        $apiKey = config('services.infobip.api_key');
        $from = config('services.infobip.from');

        $payload = [
            'messages' => [
                [
                    'from' => $from,
                    'destinations' => [
                        ['to' => $phone],
                    ],
                    'text' => $message,
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post("{$baseUrl}/sms/2/text/advanced", $payload);

        return $response->successful();
    }
}
