<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class FavoritoApiController extends Controller
{
    /**
     * Listar todos los productos favoritos del usuario autenticado.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $favoritos = $user->productosFavoritos()
            ->with(['categoria', 'imagenPrincipal', 'inventario'])
            ->get()
            ->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio_venta' => (float)$producto->precio_venta,
                    'precio_formateado' => '$ ' . number_format($producto->precio_venta, 0, ',', '.') . ' COP',
                    'stock_disponible' => (int)$producto->stock_disponible,
                    'estado_stock' => $producto->estado_stock,
                    'categoria' => $producto->categoria ? $producto->categoria->nombre : null,
                    'imagen_url' => $producto->imagenPrincipal
                        ? asset('storage/' . $producto->imagenPrincipal->url_imagen)
                        : null,
                    'fecha_guardado' => $producto->pivot->fecha ?? null,
                ];
            });

        return response()->json([
            'success' => true,
            'count' => $favoritos->count(),
            'data' => $favoritos,
        ]);
    }

    /**
     * Alternar (agregar o quitar) producto de favoritos.
     */
    public function toggle(Request $request, $producto_id)
    {
        $user = $request->user();
        $producto = Producto::findOrFail($producto_id);

        $result = $user->productosFavoritos()->toggle([
            $producto->id => ['fecha' => now()]
        ]);

        $isFavorito = in_array($producto->id, $result['attached'] ?? []);

        return response()->json([
            'success' => true,
            'is_favorito' => $isFavorito,
            'producto_id' => $producto->id,
            'message' => $isFavorito 
                ? '¡Producto agregado a tus favoritos!' 
                : 'Producto eliminado de tus favoritos',
        ]);
    }
}

