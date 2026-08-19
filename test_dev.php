<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$pedido = App\Models\Pedido::where('estado', 'Devolución solicitada')->first();

if($pedido) {
    App\Models\Devolucion::create([
        'pedido_id' => $pedido->id,
        'user_id' => $pedido->user_id,
        'motivo' => 'Motivo de prueba generado porque la tabla se creó después',
        'estado' => 'PENDIENTE',
        'productos' => [['producto_id' => 1, 'cantidad' => 1]]
    ]);
    echo 'Created devolucion for pedido ' . $pedido->id;
} else {
    echo 'No pedido found';
}
