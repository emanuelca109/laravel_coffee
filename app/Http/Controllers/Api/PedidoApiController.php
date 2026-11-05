<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Devolucion;
use App\Models\Direccion;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PedidoApiController extends Controller
{
    /**
     * Procesar checkout de compra (desde carrito o compra directa) para Flutter.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'modo' => 'nullable|in:carrito,directo',
            // En caso de compra directa:
            'producto_id' => 'required_if:modo,directo|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1',
            // Dirección: o se pasa direccion_id existente o se pasan los datos para crearla
            'direccion_id' => 'nullable|exists:direcciones,id',
            'direccion' => 'required_without:direccion_id|string',
            'municipio' => 'nullable|string',
            'departamento' => 'nullable|string',
            'telefono' => 'nullable|string',
            'nombre_completo' => 'nullable|string',
            'nombre_direccion' => 'nullable|string',
        ]);

        $user = $request->user();
        $modo = $request->input('modo', 'carrito');

        // Determinar ítems a procesar
        $itemsAProcesar = [];
        if ($modo === 'directo') {
            $prodId = (int)$request->producto_id;
            $cant = (int)($request->cantidad ?? 1);
            $itemsAProcesar[$prodId] = ['cantidad' => $cant];
        } else {
            $carrito = is_array($user->carrito) ? $user->carrito : json_decode($user->carrito ?? '[]', true);
            if (empty($carrito)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El carrito está vacío. Agrega productos antes de procesar la compra.',
                ], 422);
            }
            $itemsAProcesar = $carrito;
        }

        // Obtener o crear dirección
        $direccionId = $request->direccion_id;
        if (!$direccionId && $request->filled('direccion')) {
            $nuevaDireccion = Direccion::create([
                'cliente_id' => $user->id,
                'nombre_direccion' => $request->nombre_direccion ?? 'Principal',
                'nombre_completo' => $request->nombre_completo ?? $user->name,
                'telefono' => $request->telefono ?? ($user->telefono ?? '000000'),
                'direccion' => $request->direccion,
                'departamento' => $request->departamento ?? 'No especificado',
                'municipio' => $request->municipio ?? 'Ciudad',
                'codigo_postal' => $request->codigo_postal ?? '00000',
                'referencias' => $request->referencias ?? '',
            ]);
            $direccionId = $nuevaDireccion->id;
        }

        if (!$direccionId) {
            return response()->json([
                'success' => false,
                'message' => 'Se requiere una dirección de entrega válida.',
            ], 422);
        }

        // Verificar productos y stock
        $ids = array_keys($itemsAProcesar);
        $productos = Producto::with('inventario')->whereIn('id', $ids)->get()->keyBy('id');

        $detalles = [];
        $total = 0;
        $cantidadTotal = 0;

        foreach ($itemsAProcesar as $id => $item) {
            if (!isset($productos[$id])) {
                return response()->json([
                    'success' => false,
                    'message' => "El producto con ID {$id} ya no está disponible.",
                ], 422);
            }

            $prod = $productos[$id];
            $cant = (int)$item['cantidad'];

            if ($cant > $prod->stock_disponible) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente para '{$prod->nombre}'. Disponibles: {$prod->stock_disponible}.",
                ], 422);
            }

            $subtotal = (float)$prod->precio_venta * $cant;
            $total += $subtotal;
            $cantidadTotal += $cant;

            $detalles[] = [
                'producto_id' => $prod->id,
                'cantidad' => $cant,
                'precio_unitario' => (float)$prod->precio_venta,
                'subtotal' => $subtotal,
            ];
        }

        // Ejecutar transacción atómica de creación de pedido
        $pedido = DB::transaction(function () use ($user, $direccionId, $cantidadTotal, $total, $detalles, $request, $modo) {
            // 1. Crear Pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'direccion_id' => $direccionId,
                'numero_productos' => $cantidadTotal,
                'fecha' => now(),
                'estado' => 'Activo',
                'total' => $total,
                'numero_pedido' => 'PED-' . strtoupper(Str::random(8)),
            ]);

            // 2. Crear Detalles y actualizar Inventario
            foreach ($detalles as $detalle) {
                $detalle['pedido_id'] = $pedido->id;
                DetallePedido::create($detalle);

                $inventario = Inventario::where('producto_id', $detalle['producto_id'])->first();
                if ($inventario) {
                    $inventario->stock_reservado += $detalle['cantidad'];
                    $inventario->stock_disponible -= $detalle['cantidad'];
                    $inventario->save();

                    MovimientoInventario::create([
                        'producto_id' => $detalle['producto_id'],
                        'tipo_movimiento' => 'Salida - Reserva',
                        'cantidad' => $detalle['cantidad'],
                        'stock_anterior' => $inventario->stock_actual,
                        'stock_nuevo' => $inventario->stock_actual,
                        'fecha_movimiento' => now(),
                    ]);
                }
            }

            // 3. Registrar Pago
            Pago::create([
                'pedido_id' => $pedido->id,
                'monto' => $total,
                'metodo_pago' => $request->metodo_pago,
                'estado_pago' => 'Pendiente',
                'fecha_pago' => now(),
                'factura' => 'FACT-' . strtoupper(Str::random(6)),
            ]);

            // 4. Si fue por carrito, vaciarlo
            if ($modo !== 'directo') {
                $user->carrito = null;
                $user->save();
            }

            return $pedido;
        });

        $pedido->load(['detalles.producto.imagenPrincipal', 'direccion', 'pago']);

        return response()->json([
            'success' => true,
            'message' => '¡Pedido creado con éxito!',
            'pedido' => [
                'id' => $pedido->id,
                'numero_pedido' => $pedido->numero_pedido,
                'total' => (float)$pedido->total,
                'total_formateado' => '$ ' . number_format($pedido->total, 0, ',', '.') . ' COP',
                'numero_productos' => $pedido->numero_productos,
                'estado' => $pedido->estado,
                'fecha' => $pedido->fecha,
                'metodo_pago' => $pedido->pago ? $pedido->pago->metodo_pago : null,
                'factura' => $pedido->pago ? $pedido->pago->factura : null,
            ],
        ], 201);
    }

    /**
     * Listar pedidos activos del cliente (en preparación, enviado).
     */
    public function misPedidos(Request $request)
    {
        $user = $request->user();

        $pedidos = Pedido::with([
                'detalles.producto.imagenPrincipal',
                'direccion',
                'informacionEnvio',
                'pago'
            ])
            ->where('user_id', $user->id)
            ->whereNotIn('estado', ['Entregado', 'Devolución solicitada', 'Devuelto'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'count' => $pedidos->count(),
            'data' => $this->formatearPedidos($pedidos),
        ]);
    }

    /**
     * Listar compras finalizadas o devueltas del cliente.
     */
    public function misCompras(Request $request)
    {
        $user = $request->user();

        $compras = Pedido::with([
                'detalles.producto.imagenPrincipal',
                'direccion',
                'informacionEnvio',
                'pago'
            ])
            ->where('user_id', $user->id)
            ->whereIn('estado', ['Entregado', 'Devolución solicitada', 'Devuelto'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'count' => $compras->count(),
            'data' => $this->formatearPedidos($compras),
        ]);
    }

    /**
     * Detalle específico de un pedido.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $pedido = Pedido::with([
                'detalles.producto.imagenPrincipal',
                'direccion',
                'informacionEnvio',
                'pago'
            ])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatearPedidoIndividual($pedido),
        ]);
    }

    /**
     * Solicitar devolución para un pedido entregado.
     */
    public function solicitarDevolucion(Request $request, $id)
    {
        $user = $request->user();

        $pedido = Pedido::where('user_id', $user->id)
            ->where('id', $id)
            ->where('estado', 'Entregado')
            ->firstOrFail();

        $request->validate([
            'motivo' => 'required|string|max:1000',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $devolucion = Devolucion::create([
            'pedido_id' => $pedido->id,
            'user_id' => $user->id,
            'motivo' => $request->motivo,
            'estado' => 'PENDIENTE',
            'productos' => $request->productos,
        ]);

        $pedido->estado = 'Devolución solicitada';
        $pedido->save();

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de devolución enviada correctamente. Nuestro equipo la revisará.',
            'devolucion' => $devolucion,
        ]);
    }

    private function formatearPedidos($pedidos)
    {
        return $pedidos->map(fn ($p) => $this->formatearPedidoIndividual($p));
    }

    private function formatearPedidoIndividual($pedido)
    {
        return [
            'id' => $pedido->id,
            'numero_pedido' => $pedido->numero_pedido,
            'fecha' => $pedido->fecha,
            'estado' => $pedido->estado,
            'total' => (float)$pedido->total,
            'total_formateado' => '$ ' . number_format($pedido->total, 0, ',', '.') . ' COP',
            'numero_productos' => $pedido->numero_productos,
            'pago' => $pedido->pago ? [
                'metodo' => $pedido->pago->metodo_pago,
                'estado' => $pedido->pago->estado_pago,
                'factura' => $pedido->pago->factura,
            ] : null,
            'envio' => $pedido->informacionEnvio ? [
                'transportadora' => $pedido->informacionEnvio->transportadora,
                'estado' => $pedido->informacionEnvio->estado,
                'fecha_envio' => $pedido->informacionEnvio->fecha_envio,
                'fecha_entrega' => $pedido->informacionEnvio->fecha_entrega,
            ] : null,
            'direccion' => $pedido->direccion ? [
                'nombre_direccion' => $pedido->direccion->nombre_direccion,
                'nombre_completo' => $pedido->direccion->nombre_completo,
                'direccion' => $pedido->direccion->direccion,
                'municipio' => $pedido->direccion->municipio,
                'departamento' => $pedido->direccion->departamento,
                'telefono' => $pedido->direccion->telefono,
            ] : null,
            'detalles' => $pedido->detalles->map(function ($det) {
                return [
                    'id' => $det->id,
                    'producto_id' => $det->producto_id,
                    'nombre' => $det->producto ? $det->producto->nombre : 'Producto no disponible',
                    'cantidad' => $det->cantidad,
                    'precio_unitario' => (float)$det->precio_unitario,
                    'subtotal' => (float)$det->subtotal,
                    'imagen_url' => ($det->producto && $det->producto->imagenPrincipal)
                        ? asset('storage/' . $det->producto->imagenPrincipal->url_imagen)
                        : null,
                ];
            }),
        ];
    }
}

