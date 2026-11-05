<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\FavoritoApiController;
use App\Http\Controllers\Api\CarritoApiController;
use App\Http\Controllers\Api\DireccionApiController;
use App\Http\Controllers\Api\PedidoApiController;
use App\Http\Controllers\Api\AdminApiController;

/*
|--------------------------------------------------------------------------
| Rutas API para Conexión con Flutter y Dart
|--------------------------------------------------------------------------
|
| Todas las respuestas están en formato JSON con códigos de estado HTTP
| estándar y soporte de autenticación Bearer Token (Sanctum / Token API).
|
*/

// =========================================================
// 1. RUTAS PÚBLICAS (Catálogo & Autenticación)
// =========================================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categorias', [CategoriaApiController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaApiController::class, 'show']);

Route::get('/productos', [ProductoApiController::class, 'index']);
Route::get('/productos/{id}', [ProductoApiController::class, 'show']);
Route::get('/productos/{id}/imagenes', [ProductoApiController::class, 'imagenes']);

// =========================================================
// 2. RUTAS PROTEGIDAS (Cliente - Requiere Bearer Token)
// =========================================================
Route::middleware('auth.api')->group(function () {

    // Perfil del Usuario
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'updateProfile']);
    Route::put('/me/password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favoritos
    Route::get('/favoritos', [FavoritoApiController::class, 'index']);
    Route::post('/favoritos/{producto}/toggle', [FavoritoApiController::class, 'toggle']);

    // Carrito de Compras
    Route::get('/carrito', [CarritoApiController::class, 'index']);
    Route::post('/carrito/agregar', [CarritoApiController::class, 'agregar']);
    Route::put('/carrito/actualizar', [CarritoApiController::class, 'actualizar']);
    Route::delete('/carrito/eliminar/{producto_id}', [CarritoApiController::class, 'eliminar']);
    Route::delete('/carrito/vaciar', [CarritoApiController::class, 'vaciar']);

    // Direcciones de Envío
    Route::apiResource('direcciones', DireccionApiController::class);

    // Checkout y Pedidos del Cliente
    Route::post('/checkout', [PedidoApiController::class, 'checkout']);
    Route::get('/mis-pedidos', [PedidoApiController::class, 'misPedidos']);
    Route::get('/mis-compras', [PedidoApiController::class, 'misCompras']);
    Route::get('/pedidos/{id}', [PedidoApiController::class, 'show']);
    Route::post('/pedidos/{id}/devolucion', [PedidoApiController::class, 'solicitarDevolucion']);

    // =========================================================
    // 3. RUTAS DE ADMINISTRACIÓN (Módulo Admin en Móvil)
    // =========================================================
    Route::prefix('admin')->middleware('admin.api')->group(function () {
        Route::get('/dashboard', [AdminApiController::class, 'dashboard']);
        Route::get('/inventario', [AdminApiController::class, 'inventario']);
        Route::get('/movimientos', [AdminApiController::class, 'movimientos']);
        Route::post('/movimientos', [AdminApiController::class, 'registrarMovimiento']);
        Route::get('/pedidos', [AdminApiController::class, 'pedidos']);
        Route::put('/pedidos/{id}/estado', [AdminApiController::class, 'updatePedidoEstado']);
        Route::get('/envios', [AdminApiController::class, 'envios']);
        Route::put('/envios/{pedido_id}', [AdminApiController::class, 'updateEnvio']);
        Route::get('/devoluciones', [AdminApiController::class, 'devoluciones']);
        Route::put('/devoluciones/{id}', [AdminApiController::class, 'updateDevolucion']);
        Route::get('/ventas', [AdminApiController::class, 'ventas']);
        Route::get('/proveedores', [AdminApiController::class, 'proveedores']);
    });
});
