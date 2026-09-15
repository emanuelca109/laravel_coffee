# Módulo de Movimientos de Inventario (Kardex - Administrador)

Audita y registra cada variación en el stock de productos, garantizando la trazabilidad histórica de entradas y salidas.

---

## 1. Archivos Clave
- **Vista:** `resources/views/admin/movimientos/index.blade.php`
- **Controlador:** `App\Http\Controllers\Admin\MovimientoController.php` (`index`)
- **Modelo:** `App\Models\Movimiento.php`
- **Ruta:** `Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index')`

---

## 2. Tipos de Movimientos Registrados

1. **Entrada:**
   - Compras de insumos o café a proveedores.
   - Reingreso por devoluciones aprobadas.
2. **Salida:**
   - Despacho y venta de productos por pedidos confirmados.
   - Mermas, muestras comerciales o productos dañados.
3. **Ajuste:**
   - Correcciones de conteo físico manual tras auditorías de bodega.

---

## 3. Datos del Registro de Kardex
Cada movimiento almacena:
- Producto involucrado y categoría.
- Tipo de movimiento (`Entrada`, `Salida`, `Ajuste`).
- Cantidad modificada.
- Stock anterior y stock resultante.
- Motivo o justificación del movimiento.
- Fecha y hora exacta de la transacción.
