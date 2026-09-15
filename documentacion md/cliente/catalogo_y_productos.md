# Módulo de Catálogo y Productos (Cliente)

Este módulo permite a los clientes explorar, buscar y visualizar detalladamente los cafés y productos disponibles en la tienda.

---

## 1. Vistas Involucradas
- **Inicio / Catálogo:** `resources/views/welcome.blade.php`
- **Detalle de Producto:** `resources/views/cliente/productos/detalles.blade.php`
- **Controlador:** `App\Http\Controllers\Cliente\ClienteController.php` (`inicio`, `verProducto`)

---

## 2. Funcionalidades Principales

### A. Filtrado por Categorías
- El catálogo permite filtrar los productos según su categoría seleccionada (Café en Grano, Molido, etc.).
- Las categorías se ordenan mostrando las más recientes primero (`Categoria::latest()`).
- Los productos filtrados se cargan dinámicamente sin recargar toda la página.

### B. Búsqueda de Productos
- Un buscador superior permite localizar productos por nombre o descripción en tiempo real.

### C. Vista Detallada del Producto
- **Galería de Imágenes:** Visualización de la imagen principal y miniaturas secundarias con cambio al hacer clic o hover.
- **Información de Stock:** Muestra el stock disponible en tiempo real y el estado del producto (Disponible / Agotado).
- **Acciones Rápidas:**
  - Selector de cantidad.
  - Botón **"Añadir al Carrito"** (se ejecuta vía AJAX sin recargar la página).
  - Botón **"Comprar Ahora"** (inicia el proceso de compra directa).
  - Botón de **Favoritos** (marca o desmarca con un clic).
