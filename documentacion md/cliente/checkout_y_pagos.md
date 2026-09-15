# Módulo de Checkout y Procesamiento de Pagos (Cliente)

Este módulo guía al cliente a través del flujo interactivo por pasos para concretar la compra de sus productos seleccionados.

---

## 1. Vistas y Controladores
- **Modal de Checkout:** Integrado en `resources/views/cliente/carrito/index.blade.php` y `resources/views/cliente/partials/modal-directo.blade.php`.
- **Controlador:** `App\Http\Controllers\Cliente\CheckoutController.php` (`procesar`, `exito`).

---

## 2. Pasos del Proceso de Pago

### Paso 1: Dirección de Envío
- El usuario puede seleccionar una de sus direcciones previamente guardadas en la base de datos o registrar una nueva directamente desde el modal (Casa, Trabajo, Otro).
- Puede marcar una dirección como principal para futuras compras.

### Paso 2: Método de Pago
- Selección del método de pago preferido:
  - **Nequi** (Transferencia directa)
  - **Daviplata**
  - **PSE** (Pago seguro en línea)
  - **Tarjeta de Crédito / Débito**

### Paso 3: Resumen y Confirmación
- Visualización detallada del costo total de los productos y confirmación de que el envío es gratuito.
- Botón final de confirmación que procesa la orden mediante una transacción segura en base de datos.

### Paso 4: Éxito y Generación de Factura
- Muestra el número de pedido generado, actualiza el inventario y permite al cliente visualizar o descargar su factura de venta en PDF.
