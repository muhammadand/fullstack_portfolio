<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $response = Gemini::models()->list();
    foreach ($response->models as $model) {
        echo $model->name . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
