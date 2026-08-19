<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create missing inventory records for products
foreach (App\Models\Producto::whereDoesntHave('inventario')->get() as $prod) {
    App\Models\Inventario::create([
        'producto_id' => $prod->id,
        'stock_actual' => $prod->stock_actual,
        'stock_reservado' => 0,
        'stock_disponible' => $prod->stock_actual,
        'fecha_actualizacion' => now()
    ]);
}

// Reset Pedido 1 to 'Pendiente' so the user can test Entregado flow
$p = App\Models\Pedido::find(1);
if($p) {
    $p->estado = 'Pendiente';
    $p->save();
}
echo "Done";
