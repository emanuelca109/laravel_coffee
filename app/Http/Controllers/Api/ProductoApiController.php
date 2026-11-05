<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoApiController extends Controller
{
    /**
     * Listar productos con filtros para Flutter (búsqueda, categoría, paginación).
     */
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'imagenPrincipal', 'inventario'])
            ->where('estado', 'Activo');

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Búsqueda por texto (nombre o descripción)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por rango de precios
        if ($request->filled('precio_min')) {
            $query->where('precio_venta', '>=', (float)$request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio_venta', '<=', (float)$request->precio_max);
        }

        // Ordenamiento
        $sortBy = $request->query('sort', 'latest');
        match ($sortBy) {
            'precio_asc' => $query->orderBy('precio_venta', 'asc'),
            'precio_desc' => $query->orderBy('precio_venta', 'desc'),
            'nombre' => $query->orderBy('nombre', 'asc'),
            default => $query->latest(),
        };

        $perPage = min(50, max(1, (int)$request->query('per_page', 12)));
        $productos = $query->paginate($perPage);

        // Mapear URLs absolutas para Flutter y stock
        $userId = auth('sanctum')->id() ?? auth()->id();
        $favoritosIds = [];
        if ($userId) {
            $favoritosIds = \Illuminate\Support\Facades\DB::table('favoritos')
                ->where('user_id', $userId)
                ->pluck('producto_id')
                ->toArray();
        }

        $productos->getCollection()->transform(function ($producto) use ($favoritosIds) {
            $producto->imagen_url = $producto->imagenPrincipal
                ? asset('storage/' . $producto->imagenPrincipal->url_imagen)
                : null;
            $producto->stock_disponible = $producto->stock_disponible;
            $producto->estado_stock = $producto->estado_stock;
            $producto->is_favorito = in_array($producto->id, $favoritosIds);
            return $producto;
        });

        return response()->json([
            'success' => true,
            'data' => $productos->items(),
            'pagination' => [
                'current_page' => $productos->currentPage(),
                'last_page' => $productos->lastPage(),
                'per_page' => $productos->perPage(),
                'total' => $productos->total(),
            ],
        ]);
    }

    /**
     * Ver detalles completos de un producto específico.
     */
    public function show($id)
    {
        $producto = Producto::with([
            'categoria',
            'proveedor',
            'imagenes',
            'imagenPrincipal',
            'inventario'
        ])->findOrFail($id);

        $userId = auth('sanctum')->id() ?? auth()->id();
        $isFavorito = false;
        if ($userId) {
            $isFavorito = \Illuminate\Support\Facades\DB::table('favoritos')
                ->where('user_id', $userId)
                ->where('producto_id', $producto->id)
                ->exists();
        }

        // Mapear URLs completas de las imágenes
        $imagenesFormateadas = $producto->imagenes->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => asset('storage/' . $img->url_imagen),
                'descripcion' => $img->descripcion,
                'principal' => (bool)$img->principal,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio_compra' => (float)$producto->precio_compra,
                'precio_venta' => (float)$producto->precio_venta,
                'precio_formateado' => '$ ' . number_format($producto->precio_venta, 0, ',', '.') . ' COP',
                'stock_actual' => (int)$producto->stock_actual,
                'stock_disponible' => (int)$producto->stock_disponible,
                'stock_reservado' => (int)$producto->stock_reservado,
                'stock_minimo' => (int)$producto->stock_minimo,
                'estado_stock' => $producto->estado_stock,
                'estado' => $producto->estado,
                'categoria' => $producto->categoria,
                'proveedor' => $producto->proveedor,
                'imagen_principal' => $producto->imagenPrincipal 
                    ? asset('storage/' . $producto->imagenPrincipal->url_imagen) 
                    : null,
                'imagenes' => $imagenesFormateadas,
                'is_favorito' => $isFavorito,
            ],
        ]);
    }

    /**
     * Obtener únicamente las imágenes de un producto.
     */
    public function imagenes($id)
    {
        $producto = Producto::with('imagenes')->findOrFail($id);

        $imagenes = $producto->imagenes->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => asset('storage/' . $img->url_imagen),
                'descripcion' => $img->descripcion,
                'principal' => (bool)$img->principal,
            ];
        });

        return response()->json([
            'success' => true,
            'producto_id' => $producto->id,
            'data' => $imagenes,
        ]);
    }
}

