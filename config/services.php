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
        // API key QRIS mengikuti mode Scalify Pay (lihat ScalifyPayService::getApiKey()).
        'project' => env('SCALIFY_PROJECT', ''),
    ],

    'digiflazz' => [
        'url' => env('DIGIFLAZZ_URL') ?: 'https://api.digiflazz.com/v1',
        'username' => env('DIGIFLAZZ_USERNAME') ?: 'tuwumiWXAdqg',
        // Mode default bila admin belum memilih (switch di Admin > Digiflazz > Cek Saldo & Akun).
        // Kosong = otomatis: production kalau hanya key production yang ada.
        'mode' => env('DIGIFLAZZ_MODE'),
        // Key per mode. DIGIFLAZZ_API_KEY lama tetap jalan: awalan "dev-" = development,
        // selain itu = production (key production Digiflazz tidak punya awalan).
        'api_keys' => [
            'development' => env('DIGIFLAZZ_DEV_API_KEY') ?: (str_starts_with((string) env('DIGIFLAZZ_API_KEY'), 'dev-') ? env('DIGIFLAZZ_API_KEY') : ''),
            'production' => env('DIGIFLAZZ_PROD_API_KEY') ?: (env('DIGIFLAZZ_API_KEY') && !str_starts_with((string) env('DIGIFLAZZ_API_KEY'), 'dev-') ? env('DIGIFLAZZ_API_KEY') : ''),
        ],
        'webhook_secret' => env('DIGIFLAZZ_WEBHOOK_SECRET', ''),
        // Token untuk endpoint internal /api/digiflazz/* (Postman / server lain). Kosong = endpoint ditolak.
        'internal_token' => env('DIGIFLAZZ_INTERNAL_TOKEN', ''),
    ],

    // Push notification ke HP admin (AdminNotifier). Dimatikan saat test (phpunit.xml).
    'admin_push' => [
        'enabled' => env('ADMIN_PUSH_ENABLED', true),
    ],

    // Scalify Pay (QRIS). Mode sandbox/production dipilih admin (Admin > Payment Gateway).
    // Key lama (SCALIFY_PAY_API_KEY / SCALIFY_QRIS_API_KEY) tetap jalan: awalan pk_test_ = sandbox, selain itu production.
    'scalify_pay' => [
        'mode' => env('SCALIFY_PAY_MODE'), // kosong = otomatis
        'base_urls' => [
            'production' => env('SCALIFY_PAY_URL') ?: 'http://pay.scalifyintellegence.my.id/api/v1',
            'sandbox' => env('SCALIFY_PAY_SANDBOX_URL') ?: (env('SCALIFY_PAY_URL') ?: 'http://pay.scalifyintellegence.my.id/api/v1'),
        ],
        'api_keys' => (function () {
            $legacy = (string) (env('SCALIFY_PAY_API_KEY') ?: env('SCALIFY_QRIS_API_KEY') ?: env('QRIS_API_KEY') ?: '');
            $legacyIsSandbox = str_starts_with($legacy, 'pk_test');

            return [
                'production' => env('SCALIFY_PAY_PRODUCTION_API_KEY') ?: ($legacy !== '' && !$legacyIsSandbox ? $legacy : ''),
                'sandbox' => env('SCALIFY_PAY_SANDBOX_API_KEY') ?: ($legacyIsSandbox ? $legacy : ''),
            ];
        })(),
    ],

    // API publik artikel blog (POST /api/blogs): user yang dicatat sebagai penulis. Kosong = user pertama.
    'blog_api' => [
        'author_id' => env('BLOG_API_AUTHOR_ID'),
    ],

    // Lokasi file sitemap.xml (default public/sitemap.xml). Test memakai file sementara.
    'sitemap' => [
        'path' => env('SITEMAP_PATH'),
    ],

    // Midtrans: server key untuk verifikasi signature webhook (kosong = verifikasi dilewati).
    'midtrans' => [
        'server_key' => env('MIDTRANS_SERVER_KEY'),
    ],

    // Link grup WhatsApp komunitas partner (banner dashboard affiliate).
    'partner_group_url' => env('SCALIFY_PARTNER_GROUP_URL', 'https://chat.whatsapp.com/H3W4qaoRvBJ0s2jpVi7OB9?s=cl&p=i&mlu=4&ilr=4&iam=2'),

];
