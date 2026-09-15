# Módulo de Pedidos (Administrador)

Gestiona la recepción, actualización de estado y seguimiento de todas las órdenes de compra realizadas por los clientes.

---

## 1. Archivos Clave
- **Vistas:** `resources/views/admin/pedidos/index.blade.php`, `show.blade.php`
- **Controlador:** `App\Http\Controllers\PedidoController.php`
- **Modelos:** `App\Models\Pedido.php`, `App\Models\PedidoDetalle.php`

---

## 2. Funcionalidades del Módulo

1. **Listado de Órdenes:** Visualización del ID del pedido, nombre del cliente, fecha, total a pagar y estado.
2. **Estados del Pedido:**
   - `Pendiente`: Pedido registrado en espera de confirmación.
   - `Pagado / Confirmado`: Pago verificado.
   - `En Preparación`: Empaque y alistamiento del café/producto.
   - `Enviado`: Entregado a la empresa de transporte.
   - `Entregado`: Finalizado exitosamente.
   - `Cancelado`: Orden anulada.
3. **Detalle del Pedido:** Visualización de la dirección de entrega, método de pago, ítems adquiridos, precios unitarios y factura generada.
