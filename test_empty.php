<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Auth::loginUsingId(1); // Assuming admin or user 1 has NO orders. Or we can just pass an empty collection.
    $pedidos = collect(); // empty collection
    
    $html = view('cliente.cuenta.pedidos', ['pedidos' => $pedidos])->render();
    echo "SUCCESS_EMPTY_RENDER";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine();
}
