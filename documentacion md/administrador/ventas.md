# Módulo de Ventas (Administrador)

Proporciona análisis financiero detallado, métricas de ingresos, costos de compra, ganancias netas y registro de transacciones.

---

## 1. Archivos Clave
- **Vista:** `resources/views/admin/ventas/index.blade.php`
- **Controlador:** `App\Http\Controllers\VentaController.php` (`index`)
- **Ruta:** `Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index')`

---

## 2. Indicadores y Filtros del Módulo

### A. Filtros por Periodo de Tiempo
Permite consultar los datos con un solo clic filtrando por:
- **Hoy**
- **Semana**
- **Mes**
- **Año**
- **Todo el Histórico**

### B. Tarjetas de Resumen Financiero
1. **Ventas Completadas:** Número total de transacciones cerradas.
2. **Ingresos Totales:** Suma acumulada de los precios de venta cobrados.
3. **Costo Total:** Suma acumulada del costo de compra de los productos vendidos.
4. **Ganancia Neta y Margen:** `Ingresos - Costo Total` y porcentaje de margen de utilidad (`%`).

### C. Barra de Distribución de Ingresos
- Representación gráfica del balance porcentual entre el costo de compra y la ganancia neta.

### D. Tabla de Registro y Detalle
- Listado de ventas con cliente, fecha, costo, precio de venta, ganancia y margen.
- **Modal de Detalle:** Desglose completo de productos, cantidades y subtotales por venta.
