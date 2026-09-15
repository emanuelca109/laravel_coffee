# Módulo de Proveedores (Administrador)

Gestiona la información de contacto y detalles comerciales de las fincas cafeteras y distribuidores de insumos.

---

## 1. Archivos Clave
- **Vistas:** `resources/views/admin/proveedores/index.blade.php`, modales de creación y edición.
- **Controlador:** `App\Http\Controllers\ProveedoresController.php`
- **Modelo:** `App\Models\Proveedor.php`

---

## 2. Operaciones y Campos Principales

1. **Datos de Contacto:** Razón social / Nombre, teléfono, correo electrónico, dirección y persona de contacto.
2. **Historial y Relaciones:** Vinculación directa con los productos que suministra.
3. **Ordenamiento:** Lista paginada ordenada mostrando los últimos proveedores registrados primero (`Proveedor::latest()->paginate(10)`).
4. **Acciones CRUD:** Creación, edición y eliminación instantánea con feedback visual.
