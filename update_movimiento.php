<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;
use App\Models\MovimientoInventario;

$p = Producto::where('nombre', 'like', '%herbicida x 7 L%')->first();
if ($p) {
    $m = MovimientoInventario::where('producto_id', $p->id)->where('tipo_movimiento', 'Entrada - Compra')->first();
    if ($m) {
        $m->cantidad = 30;
        $m->stock_nuevo = 30;
        $m->save();
        echo "Record updated successfully!\n";
    } else {
        echo "Movement not found.\n";
    }
} else {
    echo "Product not found.\n";
}
