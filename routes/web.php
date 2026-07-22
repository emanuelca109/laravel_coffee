<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;
//para cliente
use App\Http\Controllers\Cliente\ClienteController;

//cliente
Route::get('/', [ClienteController::class, 'inicio'])->name('inicio');
Route::get('/producto/{id}', [ClienteController::class, 'verProducto'])
    ->name('producto.ver');
Route::get('/favoritos', [ClienteController::class, 'favoritos'])->name('favoritos');
// Ruta para agregar/quitar favoritos
Route::get('/favorito/{producto}/toggle', [ClienteController::class, 'toggleFavorito'])
    ->name('favorito.toggle')
    ->middleware('auth');
Route::get('/carrito', [ClienteController::class, 'carrito'])->name('carrito');
Route::post('/carrito/agregar/{producto}', [ClienteController::class, 'agregarAlCarrito'])->name('carrito.agregar');
Route::post('/carrito/actualizar/{producto}', [ClienteController::class, 'actualizarCarrito'])->name('carrito.actualizar');
Route::post('/carrito/eliminar/{producto}', [ClienteController::class, 'eliminarDelCarrito'])->name('carrito.eliminar');
// Ruta para comprar directamente sin afectar carrito
Route::post('/carrito/compra-directa/{producto}', [ClienteController::class, 'compraDirecta'])->name('carrito.compraDirecta')->middleware('auth');
// Ruta para comprar, requiere auth. Si no está logueado lo manda a /login.
Route::get('/carrito/comprar', [ClienteController::class, 'comprarCarrito'])->name('carrito.comprar')->middleware('auth');
Route::post('/checkout/procesar', [\App\Http\Controllers\Cliente\CheckoutController::class, 'procesar'])->name('checkout.procesar')->middleware('auth');
Route::get('/checkout/exito/{pedido}', [\App\Http\Controllers\Cliente\CheckoutController::class, 'exito'])->name('checkout.exito')->middleware('auth');
// Ruta para la página de "Mi cuenta" (perfil del usuario)
Route::get('/cuenta', [ClienteController::class, 'cuenta'])->name('cuenta');
Route::post('/cuenta/actualizar', [ClienteController::class, 'actualizarPerfil'])->name('cuenta.actualizar')->middleware('auth');
Route::get('/cuenta/seguridad', [ClienteController::class, 'seguridad'])->name('cuenta.seguridad')->middleware('auth');
Route::post('/cuenta/seguridad/actualizar', [ClienteController::class, 'actualizarPassword'])->name('cuenta.seguridad.actualizar')->middleware('auth');
Route::get('/cuenta/mis-pedidos', [ClienteController::class, 'misPedidos'])->name('cuenta.pedidos')->middleware('auth');
Route::get('/cuenta/mis-compras', [ClienteController::class, 'misCompras'])->name('cuenta.compras')->middleware('auth');
Route::get('/cuenta/mis-compras/{pedido}/ver-factura', [ClienteController::class, 'verFactura'])->name('cuenta.compras.ver_factura')->middleware('auth');
Route::get('/cuenta/mis-compras/{pedido}/factura', [ClienteController::class, 'descargarFactura'])->name('cuenta.compras.factura')->middleware('auth');
Route::post('/cuenta/mis-compras/{pedido}/devolucion', [ClienteController::class, 'solicitarDevolucion'])->name('cuenta.compras.devolucion')->middleware('auth');

//ESTO ES PARA EL CONTROLLER DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'welcome'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('direcciones', \App\Http\Controllers\DireccionController::class)->parameters([
        'direcciones' => 'direccion'
    ]);
});
//admin
Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('proveedores', ProveedoresController::class );
Route::get('/inventarios', [InventarioController::class, 'index'])->name('inventarios.index');
Route::resource('pedidos', PedidoController::class);
Route::get('/ventas', [\App\Http\Controllers\VentaController::class, 'index'])->name('ventas.index');
Route::get('/movimientos', [\App\Http\Controllers\Admin\MovimientoController::class, 'index'])->name('movimientos.index');
Route::get('/envios', [\App\Http\Controllers\Admin\EnvioController::class, 'index'])->name('envios.index');
Route::put('/envios/{pedido}', [\App\Http\Controllers\Admin\EnvioController::class, 'update'])->name('envios.update');
Route::get('/devoluciones', [\App\Http\Controllers\Admin\DevolucionController::class, 'index'])->name('devoluciones.index');
Route::put('/devoluciones/{devolucion}', [\App\Http\Controllers\Admin\DevolucionController::class, 'update'])->name('devoluciones.update');

// API endpoint para obtener imágenes de un producto
Route::get('/api/productos/{producto}/imagenes', [ProductoController::class, 'obtenerImagenes']);

require __DIR__.'/auth.php';
