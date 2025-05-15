<?php 
namespace App\Services\SMS\Providers;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use App\Services\SMS\SmsProviderInterface;
use Illuminate\Support\Facades\Log;

class NexmoSmsProvider implements SmsProviderInterface {
    public function send($phone, $message): bool {
        try {
            $basic  = new Basic(config('services.vonage.key'), config('services.vonage.secret'));
            $client = new Client($basic);
            $client->sms()->send(new SMS($phone, config('services.vonage.from'), $message));
            return true;
        } catch (\Exception $e) {
            Log::error('Nexmo failed: ' . $e->getMessage());
            return false;
        }
    }
}
