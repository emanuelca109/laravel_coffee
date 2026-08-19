<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$inv = App\Models\Inventario::where('producto_id', 2)->first();
if($inv) {
    $inv->stock_reservado = 4;
    $inv->stock_disponible = 26;
    $inv->save();
}
echo "Done";
