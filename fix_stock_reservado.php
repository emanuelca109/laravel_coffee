<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;
use App\Models\Inventario;
use App\Models\DetallePedido;
use App\Models\Pedido;

$productos = Producto::with('inventario')->get();
foreach($productos as $p) {
    if(!$p->inventario) continue;
    $reservado = 0;
    
    $detalles = DetallePedido::where('producto_id', $p->id)->get();
    
    foreach($detalles as $d) {
        $pedido = Pedido::find($d->pedido_id);
        if($pedido && in_array($pedido->estado, ['Pendiente', 'Activo', 'En Proceso', 'Enviado'])) {
            $reservado += $d->cantidad;
        }
    }
    
    // Forzar el recálculo
    $p->inventario->stock_reservado = $reservado;
    $p->inventario->stock_disponible = $p->inventario->stock_actual - $reservado;
    $p->inventario->save();
    
    echo "Producto {$p->id}: Actual = {$p->inventario->stock_actual}, Reservado = {$reservado}, Disponible = {$p->inventario->stock_disponible}\n";
}
