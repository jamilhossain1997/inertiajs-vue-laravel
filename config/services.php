<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'sms_settings' => [
        'infobip' => [
            'BD' => [
                'base_url' => env('INFOBIP_BD_BASE_URL'),
                'api_key' => env('INFOBIP_BD_API_KEY'),
                'from' => env('INFOBIP_BD_FROM'),
            ],
        ],
        'twilio' => [
            'US' => [
                'sid' => env('TWILIO_SID'),
                'token' => env('TWILIO_TOKEN'),
                'from' => env('TWILIO_FROM'),
            ],
        ],
        'nexmo' => [
            'BD' => [
                'key' => env('NEXMO_KEY'),
                'secret' => env('NEXMO_SECRET'),
                'from' => env('NEXMO_FROM'),
            ],
        ],
    ],



];
