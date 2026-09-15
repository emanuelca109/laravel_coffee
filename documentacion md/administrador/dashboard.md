# Módulo de Dashboard (Administrador)

Centro de control principal del panel administrativo que consolida las métricas y resúmenes operativos más importantes del negocio en tiempo real.

---

## 1. Archivos Clave
- **Vista:** `resources/views/dashboard.blade.php`
- **Controlador:** `App\Http\Controllers\DashboardController.php` (`welcome`)
- **Ruta:** `Route::get('/dashboard', [DashboardController::class, 'welcome'])->name('dashboard')`

---

## 2. Métricas y Tarjetas de Resumen
El Dashboard recopila y presenta los siguientes indicadores:

1. **Total de Productos:** Cantidad total de productos registrados en el catálogo.
2. **Alertas de Stock Bajo:** Número de productos cuyo `stock_actual` es menor o igual a su `stock_minimo`.
3. **Total de Pedidos:** Volumen de órdenes registradas y pedidos pendientes por despachar.
4. **Resumen de Ventas:** Monto total facturado y pedidos completados exitosamente.
5. **Últimos Movimientos:** Listado rápido de las transacciones más recientes (entradas y salidas de inventario).
