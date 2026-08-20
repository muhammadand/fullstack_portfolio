<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/partner/blogs/generate-ai', 'POST', [
    'title' => '',
    'business_category_id' => 1
]);

$controller = app(\App\Http\Controllers\Affiliate\BlogController::class);
try {
    $response = $controller->generateAi($request);
    echo $response->getContent();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
