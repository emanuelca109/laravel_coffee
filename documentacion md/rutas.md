# Documentación de Rutas (web.php)

El archivo de rutas en Laravel (`routes/web.php`) es el encargado de registrar todas las URLs de la aplicación web y decidir qué controlador o acción debe ejecutarse cuando un usuario visita dicha URL.

A continuación, se detalla la estructura y el propósito de las rutas en el proyecto **Laravel Coffee**.

## Estructura General

### 1. Rutas de Cliente (Públicas y Privadas)
Estas rutas manejan la vista de los usuarios que visitan la tienda y pueden o no requerir estar autenticados (`middleware('auth')`).

```php
// Ruta básica GET: Cuando el usuario visita la raíz ('/'), se llama al método 'inicio' del ClienteController.
Route::get('/', [ClienteController::class, 'inicio'])->name('inicio');

// Ruta GET con parámetro: {id} es una variable que pasamos al controlador para identificar el producto.
Route::get('/producto/{id}', [ClienteController::class, 'verProducto'])->name('producto.ver');

// Rutas POST (Modificación de datos): Utilizadas para enviar formularios o realizar acciones (Ej. agregar al carrito).
Route::post('/carrito/agregar/{producto}', [ClienteController::class, 'agregarAlCarrito'])->name('carrito.agregar');
```

**Nota sobre Middlewares:**
Algunas rutas terminan en `->middleware('auth')`. Esto significa que **solo usuarios que hayan iniciado sesión** pueden acceder a ellas. Si alguien no logueado intenta entrar, Laravel lo redirigirá a la página de inicio de sesión (`/login`).
Ejemplo:
```php
Route::get('/cuenta', [ClienteController::class, 'cuenta'])->name('cuenta')->middleware('auth');
```

> **Comentario general para rutas de cliente:**
> Las demás rutas de carrito, checkout y cuenta funcionan exactamente igual. Son rutas `GET` para mostrar páginas o `POST` para enviar datos. Solo cambia la URL, el método del controlador que llaman y el nombre de la ruta, pero la lógica de enrutamiento es idéntica.

---

### 2. Rutas de Administración (Recursos CRUD)
Para el panel de administración, se utilizan mucho las rutas de tipo `resource`. Un "recurso" crea automáticamente 7 rutas estándar (index, create, store, show, edit, update, destroy) para manejar todo el flujo de una entidad (Ej. Productos, Categorías, Pedidos).

```php
// Ruta Resource para Productos
Route::resource('productos', ProductoController::class);
```
Al escribir esta única línea, Laravel crea internamente las siguientes rutas:
- `GET /productos` (Listar productos)
- `GET /productos/create` (Formulario para crear)
- `POST /productos` (Guardar producto)
- `GET /productos/{producto}` (Ver un producto)
- `GET /productos/{producto}/edit` (Formulario para editar)
- `PUT/PATCH /productos/{producto}` (Actualizar producto)
- `DELETE /productos/{producto}` (Eliminar producto)

> **Comentario general para recursos:**
> Las rutas para `categorias`, `proveedores` y `pedidos` son idénticas a `productos`. Todas utilizan `Route::resource()` por lo que comparten la misma estructura de 7 rutas básicas, solo que cada una apunta a su propio controlador y maneja su respectivo modelo. No necesitas reescribir estas 7 líneas para cada tabla.

---

### 3. Rutas API (Endpoints)
Son rutas que devuelven datos en formato JSON, generalmente para ser consumidas por Javascript (Ej. peticiones asíncronas).

```php
Route::get('/api/productos/{producto}/imagenes', [ProductoController::class, 'obtenerImagenes']);
```
