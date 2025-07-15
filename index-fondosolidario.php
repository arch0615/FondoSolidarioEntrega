<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ajustar las rutas para apuntar a la carpeta fondosolidario
if (file_exists($maintenance = __DIR__.'/../fondosolidario/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../fondosolidario/vendor/autoload.php';

$app = require_once __DIR__.'/../fondosolidario/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);