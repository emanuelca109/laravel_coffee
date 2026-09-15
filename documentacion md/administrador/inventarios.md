# Módulo de Inventarios (Administrador)

Controla los niveles de existencias, stock disponible, stock mínimo y valoración del inventario en bodega.

---

## 1. Archivos Clave
- **Vista:** `resources/views/admin/inventarios/index.blade.php`
- **Controlador:** `App\Http\Controllers\InventarioController.php` (`index`)
- **Ruta:** `Route::get('/inventarios', [InventarioController::class, 'index'])->name('inventarios.index')`

---

## 2. Métricas y Monitoreo del Inventario

1. **Stock Físico vs. Stock Disponible:**
   - `stock_actual`: Total de unidades en almacén.
   - `stock_disponible`: Unidades libres para venta descontando las apartadas en pedidos en proceso.
2. **Alertas de Reposición:** Destaca visualmente en color amarillo o rojo aquellos productos que alcanzaron su `stock_minimo`.
3. **Valor Total del Inventario:** Calcula el capital invertido en bodega multiplicando `stock_actual * precio_compra`.
4. **Filtros por Estado:** Permite segmentar productos en estado "Disponible", "Stock Bajo" y "Agotado".
