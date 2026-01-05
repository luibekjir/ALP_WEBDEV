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

    'komerce' => [
        'key' => env('KOMERCE_API_KEY'),
        'base_url' => rtrim(env('KOMERCE_BASE_URL'), '/'),
    ],

    'delivery' => [
        'key_rajaongkir' => env('DELIVERY_API_KEY_RAJAONGKIR'),
        'base_url_rajaongkir' => rtrim(env('DELIVERY_BASE_URL_RAJAONGKIR'), '/'),
        'key_rajaongkir_sandbox' => env('DELIVERY_API_KEY_RAJAONGKIR_SANDBOX'),
        'base_url_rajaongkir_sandbox' => rtrim(env('DELIVERY_BASE_URL_RAJAONGKIR_SANDBOX'), '/'),
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

];
