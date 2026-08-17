# Documentación de Modelos (Eloquent)

En Laravel, los Modelos son clases que representan las tablas de tu base de datos. Cada modelo te permite interactuar con su tabla correspondiente (insertar, buscar, actualizar o eliminar registros) sin tener que escribir consultas SQL crudas, gracias al ORM llamado Eloquent.

A continuación, se explica el modelo **Producto** como ejemplo base.

## Ejemplo Principal: `Producto.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // 1. Campos asignables en masa (Mass Assignment)
    protected $fillable = [
        'nombre', 'descripcion', 'precio_compra', 'precio_venta',
        'stock_actual', 'stock_minimo', 'estado', 'categoria_id', 'proveedor_id',
    ];

    // 2. Relación: Pertenece a una Categoría (1 a muchos, inversa)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // 3. Relación: Tiene muchas Imágenes (1 a muchos)
    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }

    // 4. Accessor: Atributo calculado dinámicamente
    public function getEstadoStockAttribute()
    {
        $disponible = $this->stock_disponible;
        if ($disponible <= 0) return 'Agotado';
        return 'Disponible';
    }
}
```

### Explicación de los componentes:

1. **`$fillable`**: Es un arreglo de seguridad. Define qué columnas de la base de datos se pueden llenar de forma masiva (por ejemplo, usando `$producto->update($request->all())`). Evita que un usuario malintencionado inyecte valores en columnas que no debería (como un `id` o un `rol`).
2. **`belongsTo` (Pertenece a)**: Define una relación inversa. Un producto *pertenece a* una sola categoría. Al llamar a `$producto->categoria`, Laravel busca la categoría cuyo `id` coincida con el `categoria_id` del producto.
3. **`hasMany` (Tiene muchos)**: Define una relación de uno a muchos. Un producto puede tener *muchas* imágenes. Al llamar a `$producto->imagenes`, devuelve todas las imágenes asociadas a este producto.
4. **Accessors (`get...Attribute`)**: Permiten crear "columnas virtuales" que no existen directamente en la base de datos pero se calculan al vuelo. Aquí, `$producto->estado_stock` evalúa la lógica escrita y devuelve un texto ('Agotado', 'Disponible').

> **Comentario general para los demás Modelos:**
> Los modelos como `Categoria`, `Proveedor`, `Pedido`, o `User` tienen una estructura **idéntica**. 
> - Todos tienen su propiedad `$fillable` declarando qué campos de su tabla respectiva permiten inserción directa.
> - Solo cambian sus **relaciones**. Por ejemplo, mientras un `Producto` *pertenece a* (`belongsTo`) una `Categoria`, una `Categoria` *tiene muchos* (`hasMany`) `Productos`. 
> - Algunos pueden tener relaciones de muchos a muchos (`belongsToMany`), como un `User` que tiene muchos productos `Favoritos`. 
> La lógica base de Eloquent es exactamente la misma para todos: defino los campos permitidos y luego enlazo mis tablas mediante funciones de relación.
