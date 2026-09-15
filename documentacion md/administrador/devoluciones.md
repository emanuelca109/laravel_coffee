# Módulo de Devoluciones y Garantías (Administrador)

Permite tramitar, auditar, aprobar o rechazar las solicitudes de devolución de productos enviadas por los clientes.

---

## 1. Archivos Clave
- **Vista:** `resources/views/admin/devoluciones/index.blade.php`
- **Controlador:** `App\Http\Controllers\Admin\DevolucionController.php` (`index`, `update`)
- **Modelo:** `App\Models\Devolucion.php`
- **Rutas:**
  - `Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index')`
  - `Route::put('/devoluciones/{devolucion}', [DevolucionController::class, 'update'])->name('devoluciones.update')`

---

## 2. Flujo de Gestión de Devoluciones

1. **Recepción de Solicitud:**
   - Muestra el cliente solicitante, el pedido asociado, el producto, la fecha y la justificación o motivo de la devolución.
2. **Revisión y Decisión:**
   - **Aprobar:**
     - Cambia el estado de la solicitud a `Aprobada`.
     - Genera automáticamente un movimiento de inventario de tipo `Entrada` para reintegrar las unidades devueltas al `stock_actual`.
   - **Rechazar:**
     - Cambia el estado a `Rechazada` indicando el motivo de rechazo al cliente sin alterar el inventario.
3. **Auditoría:** Registro de fecha y usuario administrador que gestionó la solicitud.
