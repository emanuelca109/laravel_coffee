<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaApiController extends Controller
{
    /**
     * Listar categorías activas para el catálogo móvil.
     */
    public function index()
    {
        $categorias = Categoria::where('estado', 'Activo')
            ->withCount(['productos' => function ($query) {
                $query->where('estado', 'Activo');
            }])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias,
        ]);
    }

    /**
     * Ver detalle de una categoría con sus productos.
     */
    public function show($id)
    {
        $categoria = Categoria::where('estado', 'Activo')
            ->withCount('productos')
            ->findOrFail($id);

        $productos = $categoria->productos()
            ->where('estado', 'Activo')
            ->with(['imagenPrincipal', 'inventario'])
            ->latest()
            ->paginate(15);

        // Formatear productos con URLs de imágenes
        $productos->getCollection()->transform(function ($producto) {
            $producto->imagen_url = $producto->imagenPrincipal 
                ? asset('storage/' . $producto->imagenPrincipal->url_imagen) 
                : null;
            return $producto;
        });

        return response()->json([
            'success' => true,
            'categoria' => $categoria,
            'productos' => $productos,
        ]);
    }
}

