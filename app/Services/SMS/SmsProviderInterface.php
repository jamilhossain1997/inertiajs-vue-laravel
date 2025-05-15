<?php

namespace App\Services\SMS;

interface SmsProviderInterface {
    public function send($phone, $message): bool;
}