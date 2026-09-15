# Módulo de Productos (Administrador)

Gestiona el catálogo de productos, precios, stocks, relaciones de proveedores, categorías y galerías de imágenes.

---

## 1. Archivos Clave
- **Vistas:** `resources/views/admin/productos/index.blade.php`, modales de creación, edición y detalle.
- **Controlador:** `App\Http\Controllers\ProductoController.php`
- **Modelos:** `App\Models\Producto.php`, `App\Models\Imagen.php`

---

## 2. Operaciones y Campos Principales

1. **Gestión de Datos Básicos:** Nombre, descripción, precio de compra, precio de venta, categoría y proveedor asignado.
2. **Control de Inventario:**
   - `stock_actual`: Cantidad física en bodega.
   - `stock_minimo`: Umbral para alertas automáticas de reposición.
   - `estado`: Activo / Inactivo.
3. **Galería Multimedia:**
   - Carga múltiple de imágenes guardadas en el disco de almacenamiento de Laravel (`storage/app/public/productos/`).
   - Definición de imagen principal y secundarias.
4. **Búsqueda y Filtros:** Búsqueda ágil por nombre, categoría y estado de stock.
