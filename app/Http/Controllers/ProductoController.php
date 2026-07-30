<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Imagen;
use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\MovimientoInventario;

class ProductoController extends Controller
{
    /**
     * Mostrar listado
     */
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor', 'imagenes'])->paginate(10);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();

        return view(
            'admin.productos.index',
            compact('productos', 'categorias', 'proveedores')
        );
    }

    /**
     * Formulario crear
     */
    public function create()
    {
        //
    }

    /**
     * Guardar producto
     */
    public function store(Request $request)
    {
        $producto = Producto::create([

            'nombre' => $request->nombre,

            'descripcion' => $request->descripcion,

            'precio_compra' => $request->precio_compra,

            'precio_venta' => $request->precio_venta,

            'stock_actual' => $request->stock_actual,

            'stock_minimo' => $request->stock_minimo,

            'estado' => $request->estado,

            'categoria_id' => $request->categoria_id,

            'proveedor_id' => $request->proveedor_id

        ]);

        // Guardar múltiples imágenes
        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');
            $principal = true;

            foreach ($imagenes as $index => $imagen) {
                $nombreArchivo = time() . '_' . $index . '_' . $imagen->getClientOriginalName();
                $ruta = $imagen->storeAs('productos', $nombreArchivo, 'public');

                Imagen::create([
                    'url_imagen' => $ruta,
                    'descripcion' => $request->input('descripcion_imagen.' . $index),
                    'principal' => $principal,
                    'producto_id' => $producto->id,
                ]);

                $principal = false; // Solo la primera imagen es principal
            }
        }

        Inventario::create([
            'stock_actual' => $request->stock_actual,
            'stock_reservado' => 0,
            'stock_disponible' => $request->stock_actual,
            'fecha_actualizacion' => now(),
            'producto_id' => $producto->id
        ]);

        if ($request->stock_actual > 0) {
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo_movimiento' => 'Entrada - Compra',
                'cantidad' => $request->stock_actual,
                'stock_anterior' => 0,
                'stock_nuevo' => $request->stock_actual,
                'fecha_movimiento' => now()
            ]);
        }

        return redirect()
                ->route('productos.index')
                ->with('success', 'Producto creado correctamente');
    }
    /**
     * Mostrar uno
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Formulario editar
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        $oldStock = $producto->stock_actual;

        $producto->update([

            'nombre' => $request->nombre,

            'descripcion' => $request->descripcion,

            'precio_compra' => $request->precio_compra,

            'precio_venta' => $request->precio_venta,

            'stock_actual' => $request->stock_actual,

            'stock_minimo' => $request->stock_minimo,

            'estado' => $request->estado,

            'categoria_id' => $request->categoria_id,

            'proveedor_id' => $request->proveedor_id

        ]);

        $newStock = $request->stock_actual;
        
        if ($oldStock != $newStock) {
            $cantidad = abs($newStock - $oldStock);
            $tipo = $newStock > $oldStock ? 'Entrada - Ajuste' : 'Salida - Ajuste';
            
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo_movimiento' => $tipo,
                'cantidad' => $cantidad,
                'stock_anterior' => $oldStock,
                'stock_nuevo' => $newStock,
                'fecha_movimiento' => now()
            ]);
            
            // También actualizar Inventario si existe
            if ($producto->inventario) {
                $producto->inventario->stock_actual = $newStock;
                $producto->inventario->stock_disponible = $newStock - $producto->inventario->stock_reservado;
                $producto->inventario->save();
            }
        }

        // Eliminar imágenes seleccionadas
        if ($request->has('eliminar_imagenes')) {
            $ids = $request->input('eliminar_imagenes');
            $imagenesAEliminar = Imagen::whereIn('id', $ids)->where('producto_id', $producto->id)->get();
            foreach ($imagenesAEliminar as $img) {
                if (\Storage::disk('public')->exists($img->url_imagen)) {
                    \Storage::disk('public')->delete($img->url_imagen);
                }
                $img->delete();
            }
        }

        $countActual = $producto->imagenes()->count();
        $nuevas = $request->hasFile('imagenes') ? count($request->file('imagenes')) : 0;
        
        if ($countActual + $nuevas > 5) {
            return redirect()->back()->with('error', 'Un producto solo puede tener hasta 5 imágenes en total.');
        }

        // Agregar nuevas imágenes si las hay
        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');
            $tieneImagenes = $countActual > 0;

            foreach ($imagenes as $index => $imagen) {
                if ($countActual + $index >= 5) break; // Extra check just in case

                $nombreArchivo = time() . '_' . $index . '_' . $imagen->getClientOriginalName();
                $ruta = $imagen->storeAs('productos', $nombreArchivo, 'public');

                Imagen::create([
                    'url_imagen' => $ruta,
                    'descripcion' => $request->input('descripcion_imagen.' . $index),
                    'principal' => !$tieneImagenes && $index === 0,
                    'producto_id' => $producto->id,
                ]);
            }
        }

        return redirect()
                ->route('productos.index')
                ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Eliminar producto
     */
    public function destroy(string $id)
    {
        Producto::findOrFail($id)->delete();

        return redirect()
                ->route('productos.index')
                ->with('success', 'Producto eliminado correctamente');
    }

    /**
     * Obtener imágenes de un producto (API)
     */
    public function obtenerImagenes(Producto $producto)
    {
        return response()->json($producto->imagenes()->get());
    }
}