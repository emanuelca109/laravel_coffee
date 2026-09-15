# Módulo de Favoritos (Cliente)

Permite a los usuarios registrados guardar productos de su interés en una lista personalizada para comprarlos posteriormente.

---

## 1. Vistas y Controladores
- **Vista Principal:** `resources/views/cliente/favoritos/index.blade.php`
- **Controlador:** `App\Http\Controllers\Cliente\ClienteController.php` (`favoritos`, `toggleFavorito`).

---

## 2. Funcionamiento Técnico

### A. Toggle Asíncrono (Optimistic UI)
- Al hacer clic en el botón de corazón desde cualquier parte de la tienda (catálogo, detalle de producto o lista de favoritos):
  1. El icono cambia de color y escala de inmediato visualmente.
  2. Se envía una petición asíncrona a la ruta `favorito.toggle`.
  3. Si el producto ya estaba en favoritos, se elimina de la tabla pivote `favoritos`; si no estaba, se asocia al usuario autenticado.
  4. Se muestra un Toast flotante confirmando la acción ("¡Añadido a favoritos!" o "Eliminado de favoritos").

### B. Gestión desde la Vista de Favoritos
- Lista todos los productos marcados por el usuario.
- Si el usuario retira un producto directamente desde esta vista, la tarjeta se desvanece de inmediato sin recargar la página.
