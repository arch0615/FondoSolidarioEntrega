<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ajustar las rutas para apuntar directamente a la carpeta padre (sin subcarpeta laravel)
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
