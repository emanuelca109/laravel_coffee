# Módulo de Carrito de Compras (Cliente)

Gestiona la acumulación, modificación de cantidades y preparación de pedidos por parte del cliente.

---

## 1. Vistas y Controladores
- **Vista Principal:** `resources/views/cliente/carrito/index.blade.php`
- **Controlador:** `App\Http\Controllers\Cliente\ClienteController.php`
  - `agregarAlCarrito()`
  - `actualizarCarrito()`
  - `eliminarDelCarrito()`
  - `compraDirecta()`

---

## 2. Características y Flujo de Trabajo

### A. Operaciones en Tiempo Real (Sin Recarga)
- **Incrementar (`+`) o Reducir (`-`) Cantidades:** Se envían peticiones AJAX asíncronas. El sistema valida contra el `stock_disponible`, actualiza el subtotal de la fila y el total global inmediatamente.
- **Eliminar Producto:** Al presionar el icono de basura o si la cantidad llega a 0, la fila se anima suavemente y se retira del DOM.
- **Badge Contador:** El indicador numérico del carrito en el encabezado se actualiza en vivo con un efecto de rebote.

### B. Validación de Stock
- No permite agregar más unidades de las disponibles en el inventario real. Si el cliente supera el límite, se muestra una alerta flotante notificándole la disponibilidad máxima.

### C. Selección Dinámica de Ítems
- Casillas de verificación individuales y opción de "Seleccionar todo".
- El resumen de compra calcula el total a pagar únicamente sobre los productos marcados.
