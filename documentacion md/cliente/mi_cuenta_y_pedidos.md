# Módulo de Mi Cuenta, Historial de Pedidos y Direcciones (Cliente)

Centraliza la gestión del perfil del cliente, seguridad, direcciones de entrega y seguimiento de compras.

---

## 1. Vistas Involucradas
- **Perfil Personal:** `resources/views/cliente/cuenta/index.blade.php`
- **Seguridad y Contraseña:** `resources/views/cliente/cuenta/seguridad.blade.php`
- **Mis Direcciones:** `resources/views/cliente/direcciones/index.blade.php`, `create.blade.php`, `edit.blade.php`
- **Historial de Compras:** `resources/views/cliente/cuenta/compras.blade.php`
- **Controladores:**
  - `App\Http\Controllers\Cliente\ClienteController.php`
  - `App\Http\Controllers\DireccionController.php`

---

## 2. Funcionalidades Principales

### A. Gestión de Perfil y Seguridad
- Actualización de nombre y correo electrónico.
- Cambio de contraseña con validación de contraseña actual y confirmación de nueva clave.

### B. Libreta de Direcciones
- Permite agregar múltiples direcciones con departamento, municipio, código postal y referencias.
- Opción para establecer una dirección como predeterminada/principal para el checkout.
- Edición y eliminación ágil de direcciones existentes.

### C. Historial de Compras y Pedidos
- Lista cronológica de todos los pedidos realizados por el cliente.
- Visualización del estado actual del pedido: *Pendiente*, *Pagado*, *Enviado*, *Entregado*, *Cancelado*.
- **Acciones sobre Pedidos:**
  - **Ver Factura:** Abre la factura digital del pedido.
  - **Descargar PDF:** Descarga el comprobante de venta formal.
  - **Solicitar Devolución:** Formulario para registrar solicitudes de garantía o devolución con motivo y descripción.
