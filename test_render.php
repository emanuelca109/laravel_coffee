<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Auth::loginUsingId(2);
    $pedidos = \App\Models\Pedido::with(['detalles.producto.imagenes', 'direccion', 'informacionEnvio'])->where('user_id', 2)->get();
    
    $html = view('cliente.cuenta.pedidos', ['pedidos' => $pedidos])->render();
    file_put_contents('rendered_output.html', $html);
    echo "SUCCESS";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine();
}
