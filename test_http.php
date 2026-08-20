<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = env('GEMINI_API_KEY');
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $key;

$response = Illuminate\Support\Facades\Http::post($url, [
    'contents' => [
        ['parts' => [['text' => 'Hello']]]
    ]
]);

echo $response->body();
