<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoApiController extends Controller
{
    /**
     * Obtener el carrito completo del usuario autenticado.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $carritoData = $this->obtenerCarritoUsuario($user);

        $items = [];
        $total = 0;
        $totalItems = 0;

        if (!empty($carritoData)) {
            $ids = array_keys($carritoData);
            $productos = Producto::with(['imagenPrincipal', 'inventario', 'categoria'])
                ->whereIn('id', $ids)
                ->get()
                ->keyBy('id');

            foreach ($carritoData as $id => $item) {
                if (!isset($productos[$id])) continue;

                $producto = $productos[$id];
                $cantidad = (int)$item['cantidad'];
                $subtotal = (float)$producto->precio_venta * $cantidad;
                $total += $subtotal;
                $totalItems += $cantidad;

                $items[] = [
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'categoria' => $producto->categoria ? $producto->categoria->nombre : null,
                    'precio_unitario' => (float)$producto->precio_venta,
                    'precio_unitario_formateado' => '$ ' . number_format($producto->precio_venta, 0, ',', '.') . ' COP',
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'subtotal_formateado' => '$ ' . number_format($subtotal, 0, ',', '.') . ' COP',
                    'stock_disponible' => (int)$producto->stock_disponible,
                    'excede_stock' => $cantidad > $producto->stock_disponible,
                    'imagen_url' => $producto->imagenPrincipal
                        ? asset('storage/' . $producto->imagenPrincipal->url_imagen)
                        : null,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'items_count' => count($items),
                'total_unidades' => $totalItems,
                'total' => $total,
                'total_formateado' => '$ ' . number_format($total, 0, ',', '.') . ' COP',
            ],
        ]);
    }

    /**
     * Agregar un producto al carrito.
     */
    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1',
        ]);

        $user = $request->user();
        $productoId = (int)$request->producto_id;
        $cantidad = (int)($request->cantidad ?? 1);

        $producto = Producto::with('inventario')->findOrFail($productoId);

        if ($producto->estado !== 'Activo') {
            return response()->json([
                'success' => false,
                'message' => 'El producto no se encuentra disponible actualmente.',
            ], 422);
        }

        $carritoData = $this->obtenerCarritoUsuario($user);
        $cantidadActual = isset($carritoData[$productoId]) ? (int)$carritoData[$productoId]['cantidad'] : 0;
        $nuevaCantidad = $cantidadActual + $cantidad;

        if ($nuevaCantidad > $producto->stock_disponible) {
            return response()->json([
                'success' => false,
                'message' => "Solo hay {$producto->stock_disponible} unidades disponibles en stock.",
                'stock_disponible' => $producto->stock_disponible,
            ], 422);
        }

        $carritoData[$productoId] = ['cantidad' => $nuevaCantidad];
        $this->guardarCarritoUsuario($user, $carritoData);

        return response()->json([
            'success' => true,
            'message' => '¡Producto añadido al carrito!',
            'producto_id' => $productoId,
            'nueva_cantidad' => $nuevaCantidad,
            'total_items' => array_sum(array_column($carritoData, 'cantidad')),
        ]);
    }

    /**
     * Actualizar la cantidad de un producto en el carrito.
     */
    public function actualizar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:0',
        ]);

        $user = $request->user();
        $productoId = (int)$request->producto_id;
        $cantidad = (int)$request->cantidad;

        $producto = Producto::with('inventario')->findOrFail($productoId);
        $carritoData = $this->obtenerCarritoUsuario($user);

        if ($cantidad > $producto->stock_disponible) {
            return response()->json([
                'success' => false,
                'message' => "Solo hay {$producto->stock_disponible} unidades disponibles.",
                'stock_disponible' => $producto->stock_disponible,
            ], 422);
        }

        if ($cantidad <= 0) {
            unset($carritoData[$productoId]);
            $mensaje = 'Producto eliminado del carrito.';
        } else {
            $carritoData[$productoId] = ['cantidad' => $cantidad];
            $mensaje = 'Carrito actualizado correctamente.';
        }

        $this->guardarCarritoUsuario($user, $carritoData);

        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'producto_id' => $productoId,
            'cantidad' => $cantidad,
            'total_items' => array_sum(array_column($carritoData, 'cantidad')),
        ]);
    }

    /**
     * Eliminar un producto específico del carrito.
     */
    public function eliminar(Request $request, $producto_id)
    {
        $user = $request->user();
        $productoId = (int)$producto_id;
        $carritoData = $this->obtenerCarritoUsuario($user);

        if (isset($carritoData[$productoId])) {
            unset($carritoData[$productoId]);
            $this->guardarCarritoUsuario($user, $carritoData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito.',
            'total_items' => array_sum(array_column($carritoData, 'cantidad')),
        ]);
    }

    /**
     * Vaciar completamente el carrito.
     */
    public function vaciar(Request $request)
    {
        $user = $request->user();
        $this->guardarCarritoUsuario($user, []);

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado exitosamente.',
        ]);
    }

    private function obtenerCarritoUsuario($user): array
    {
        if (is_array($user->carrito)) {
            return $user->carrito;
        }
        if (is_string($user->carrito)) {
            $decoded = json_decode($user->carrito, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    private function guardarCarritoUsuario($user, array $carrito): void
    {
        $user->carrito = $carrito;
        $user->save();
    }
}

