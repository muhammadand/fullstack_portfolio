<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

try {
    Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Artisan::output();

    Artisan::call('optimize:clear');
    $optimizeOutput = Artisan::output();

    echo "<h1>Sukses!</h1>";
    echo "<h3>Output Migrasi:</h3><pre>{$migrateOutput}</pre>";
    echo "<h3>Output Optimize:</h3><pre>{$optimizeOutput}</pre>";
} catch (\Exception $e) {
    echo "<h1>Terjadi Error:</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
