# Módulo de Envíos y Logística (Administrador)

Administra el despacho, asignación de guías de transporte y seguimiento de entrega de pedidos.

---

## 1. Archivos Clave
- **Vista:** `resources/views/admin/envios/index.blade.php`
- **Controlador:** `App\Http\Controllers\Admin\EnvioController.php` (`index`, `update`)
- **Ruta:**
  - `Route::get('/envios', [EnvioController::class, 'index'])->name('envios.index')`
  - `Route::put('/envios/{pedido}', [EnvioController::class, 'update'])->name('envios.update')`

---

## 2. Funcionalidades del Módulo

1. **Control de Despachos:**
   - Lista de pedidos listos para entrega con datos del destinatario, ciudad y dirección.
2. **Asignación de Guía de Transporte:**
   - Registro de la empresa transportadora (Servientrega, Coordinadora, Interrapidísimo, Envia, etc.).
   - Número de guía de rastreo.
3. **Actualización de Estado de Entrega:**
   - Transición de estados: `Preparando`, `En Camino`, `Entregado`, `Novedad en Entrega`.
   - Notificación al cliente para que pueda consultar el estado desde su perfil de compras.
