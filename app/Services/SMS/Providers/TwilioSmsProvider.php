<?php 

namespace App\Services\SMS\Providers;

use Twilio\Rest\Client;
use App\Services\SMS\SmsProviderInterface;
use Illuminate\Support\Facades\Log;

class TwilioSmsProvider implements SmsProviderInterface {
    public function send($phone, $message): bool {
        try {
            $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
            $twilio->messages->create($phone, [
                'from' => config('services.twilio.from'),
                'body' => $message,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Twilio failed: ' . $e->getMessage());
            return false;
        }
    }
}
