<?php

namespace App\Services\SMS;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsProvider
{
    public function send(string $phone, string $message, string $countryCode = 'BD'): bool
    {
        $providers = config("sms.providers.$countryCode");

        if (!$providers || empty($providers)) {
            Log::error("No SMS providers configured for country: $countryCode");
            return false;
        }

        foreach ($providers as $providerName) {
            $success = $this->sendViaProvider($providerName, $phone, $message, $countryCode);

            if ($success) {
                return true;
            }
        }

        return false;
    }

    private function sendViaProvider(string $provider, string $phone, string $message, string $countryCode): bool
    {
        $config = config("services.sms_settings.$provider.$countryCode");

        if (!$config) {
            Log::warning("No config for provider [$provider] and country [$countryCode]");
            return false;
        }

        switch ($provider) {
            case 'infobip':
                $payload = [
                    'messages' => [
                        [
                            'from' => $config['from'],
                            'destinations' => [['to' => $phone]],
                            'text' => $message,
                        ]
                    ]
                ];

                $response = Http::withHeaders([
                    'Authorization' => "App {$config['api_key']}",
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post("{$config['base_url']}/sms/2/text/advanced", $payload);

                return $response->successful();

            case 'twilio':
                $response = Http::asForm()->withBasicAuth(
                    $config['sid'],
                    $config['token']
                )->post("https://api.twilio.com/2010-04-01/Accounts/{$config['sid']}/Messages.json", [
                    'From' => $config['from'],
                    'To' => $phone,
                    'Body' => $message,
                ]);

                return $response->successful();

            case 'nexmo':
                $response = Http::post("https://rest.nexmo.com/sms/json", [
                    'api_key' => $config['key'],
                    'api_secret' => $config['secret'],
                    'to' => $phone,
                    'from' => $config['from'],
                    'text' => $message,
                ]);

                return $response->successful();

            default:
                Log::error("Unknown provider: $provider");
                return false;
        }
    }
}
