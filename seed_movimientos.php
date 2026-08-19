<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\MovimientoInventario;

MovimientoInventario::truncate();

// 1. Entradas (por creacion de productos)
$productos = Producto::all();
foreach ($productos as $p) {
    if ($p->inventario) {
        MovimientoInventario::create([
            'producto_id' => $p->id,
            'tipo_movimiento' => 'Entrada - Compra',
            'cantidad' => $p->inventario->stock_actual, // asumiendo que este fue el inicial
            'stock_anterior' => 0,
            'stock_nuevo' => $p->inventario->stock_actual,
            'fecha_movimiento' => $p->created_at
        ]);
    }
}

// 2. Salidas y Reservas (por pedidos)
$pedidos = Pedido::with('detalles.producto.inventario')->get();
foreach ($pedidos as $pedido) {
    foreach ($pedido->detalles as $detalle) {
        if (!$detalle->producto || !$detalle->producto->inventario) continue;
        
        $stockActual = $detalle->producto->inventario->stock_actual;
        
        if ($pedido->estado == 'Entregado') {
            // Salida - Venta
            MovimientoInventario::create([
                'producto_id' => $detalle->producto_id,
                'tipo_movimiento' => 'Salida - Venta',
                'cantidad' => $detalle->cantidad,
                'stock_anterior' => $stockActual + $detalle->cantidad, // Porque ya se le restó
                'stock_nuevo' => $stockActual,
                'fecha_movimiento' => $pedido->updated_at
            ]);
        } else {
            // Salida - Reserva
            MovimientoInventario::create([
                'producto_id' => $detalle->producto_id,
                'tipo_movimiento' => 'Salida - Reserva',
                'cantidad' => $detalle->cantidad,
                'stock_anterior' => $stockActual,
                'stock_nuevo' => $stockActual,
                'fecha_movimiento' => $pedido->created_at
            ]);
        }
    }
}

echo "Movimientos generados exitosamente.\n";
