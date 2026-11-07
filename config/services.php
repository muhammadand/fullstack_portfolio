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

    'qris' => [
        'url' => env('SCALIFY_QRIS_URL', 'http://pay.scalifyintellegence.my.id/api/v1/qris/dynamic'),
        'api_key' => env('SCALIFY_QRIS_API_KEY', env('QRIS_API_KEY', '')),
        'project' => env('SCALIFY_PROJECT', ''),
    ],

    'digiflazz' => [
        'url' => env('DIGIFLAZZ_URL') ?: 'https://api.digiflazz.com/v1',
        'username' => env('DIGIFLAZZ_USERNAME') ?: 'tuwumiWXAdqg',
        // Mode default bila admin belum memilih (switch di Admin > Digiflazz > Cek Saldo & Akun).
        'mode' => env('DIGIFLAZZ_MODE', 'development'),
        // Key per mode. DIGIFLAZZ_API_KEY lama tetap dipakai sesuai awalannya (dev-/prod-).
        'api_keys' => [
            'development' => env('DIGIFLAZZ_DEV_API_KEY') ?: (str_starts_with((string) env('DIGIFLAZZ_API_KEY'), 'dev-') ? env('DIGIFLAZZ_API_KEY') : ''),
            'production' => env('DIGIFLAZZ_PROD_API_KEY') ?: (str_starts_with((string) env('DIGIFLAZZ_API_KEY'), 'prod-') ? env('DIGIFLAZZ_API_KEY') : ''),
        ],
        'webhook_secret' => env('DIGIFLAZZ_WEBHOOK_SECRET', ''),
    ],

    'scalify_pay' => [
        'base_url' => env('SCALIFY_PAY_URL', 'http://pay.scalifyintellegence.my.id/api/v1'),
        'api_key' => env('SCALIFY_PAY_API_KEY', env('SCALIFY_QRIS_API_KEY', 'pk_live_demo1234_sk_live_demo_store_secret_99887766')),
    ],

];
