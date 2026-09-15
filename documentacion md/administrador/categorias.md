# Módulo de Categorías (Administrador)

Gestiona la clasificación y organización del catálogo de cafés, insumos y herramientas.

---

## 1. Archivos Clave
- **Vistas:** `resources/views/admin/categorias/index.blade.php`, modales de creación y edición.
- **Controlador:** `App\Http\Controllers\CategoriaController.php` (Resource CRUD)
- **Modelo:** `App\Models\Categoria.php`

---

## 2. Operaciones del Módulo

1. **Listado con Paginación:** Muestra las categorías ordenadas por las más recientes primero (`Categoria::withCount('productos')->latest()->paginate(10)`), indicando la cantidad de productos asociados a cada una.
2. **Crear Categoría:** Formulario modal con validación de nombre único y descripción.
3. **Editar Categoría:** Modificación de nombres y detalles sin recargar la pantalla.
4. **Eliminar Categoría:** Borrado con confirmación previa y protección de integridad referencial.
