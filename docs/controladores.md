# Documentación de Controladores

Los Controladores en Laravel se encargan de recibir la petición HTTP del usuario (Request), procesar la lógica de negocio (consultar o modificar la base de datos a través de los Modelos) y devolver una respuesta (ya sea una Vista con HTML o datos en formato JSON).

Para esta documentación, analizaremos **`ProductoController.php`** que es un controlador de tipo "Recurso" (CRUD), ya que este patrón es el más utilizado a lo largo del sistema (especialmente en el panel de administración).

## Ejemplo Principal: `ProductoController.php`

Un controlador CRUD estándar contiene métodos principales para manejar todo el ciclo de vida de un dato. Aquí explicamos los más importantes:

### 1. Método `index()` (Listar)
Este método se usa para mostrar la tabla o listado principal de todos los registros.
```php
public function index()
{
    // Obtiene los productos con sus relaciones (Eager Loading) para optimizar consultas a la base de datos.
    // Paginate(10) divide los resultados en páginas de 10 en 10.
    $productos = Producto::with(['categoria', 'proveedor', 'imagenes'])->paginate(10);
    
    // Pasa las variables a la vista de Blade para ser mostradas en HTML
    return view('admin.productos.index', compact('productos'));
}
```

### 2. Método `store(Request $request)` (Guardar Nuevo)
Recibe los datos enviados por un formulario de creación y los inserta en la base de datos.
```php
public function store(Request $request)
{
    // 1. Se crea el registro usando Mass Assignment (usando los datos validados del $request)
    $producto = Producto::create([
        'nombre' => $request->nombre,
        'precio_venta' => $request->precio_venta,
        // ... se listan los demás campos
    ]);

    // 2. Lógica adicional específica: Ej. Guardar archivos (imágenes) o registrar movimientos
    if ($request->hasFile('imagenes')) {
        // Lógica para guardar la imagen en la carpeta del servidor y vincularla al producto
    }

    // 3. Redireccionar al usuario a la tabla principal con un mensaje de éxito
    return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
}
```

### 3. Método `update(Request $request, string $id)` (Actualizar)
Busca un registro existente, modifica sus valores con los datos recibidos del formulario de edición y guarda los cambios.
```php
public function update(Request $request, string $id)
{
    // 1. Busca el registro por su ID. Si no existe, Laravel lanza automáticamente un error 404 (gracias a findOrFail).
    $producto = Producto::findOrFail($id);
    
    // 2. Actualiza los campos con los nuevos datos recibidos
    $producto->update([
        'nombre' => $request->nombre,
        // ... otros campos modificados
    ]);

    // 3. Redireccionar de vuelta al listado con un aviso
    return redirect()->route('productos.index')->with('success', 'Producto actualizado');
}
```

### 4. Método `destroy(string $id)` (Eliminar)
Borra un registro de la base de datos.
```php
public function destroy(string $id)
{
    // Busca el registro por ID y lo elimina en una sola línea encadenada
    Producto::findOrFail($id)->delete();

    // Redirecciona al listado con mensaje de confirmación
    return redirect()->route('productos.index')->with('success', 'Producto eliminado');
}
```

> **Comentario general para los demás Controladores:**
> Los controladores como `CategoriaController`, `ProveedoresController` o `PedidoController` **son prácticamente iguales** en su estructura. 
> Todos tienen un `index` para listar, un `store` para guardar, un `update` para modificar y un `destroy` para eliminar. Lo único que cambia en los demás es:
> 1. El **Modelo** al que llaman (Ej: en lugar de `Producto::create` hacen `Categoria::create` o `Proveedor::create`).
> 2. Los **campos** específicos que reciben del `$request` (dependiendo de las columnas de cada tabla).
> 3. Las **vistas** que retornan (Ej: `return view('admin.categorias.index')` en vez de productos).
> 
> La mecánica y el flujo de información se repite como un estándar en toda la aplicación, por lo que entendiendo cómo funciona el controlador de Productos, entenderás automáticamente cómo funcionan los demás controladores.
