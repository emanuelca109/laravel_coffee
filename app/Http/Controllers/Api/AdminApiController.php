<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Devolucion;
use App\Models\Imagen;
use App\Models\InformacionEnvio;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    /**
     * Dashboard general de métricas del negocio.
     */
    public function dashboard()
    {
        $totalProductos = Producto::count();
        $productosActivos = Producto::where('estado', 'Activo')->count();

        $bajoStock = Producto::get()->filter(function ($p) {
            return $p->estado_stock !== 'Disponible';
        })->count();

        $pedidosActivos = Pedido::where('estado', 'Activo')->count();
        $ventasHoy = Pedido::where('estado', 'Entregado')
            ->whereDate('updated_at', Carbon::today())
            ->sum('total');

        $devolucionesPendientes = Devolucion::where('estado', 'PENDIENTE')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_productos' => $totalProductos,
                'productos_activos' => $productosActivos,
                'alertas_stock' => $bajoStock,
                'pedidos_activos' => $pedidosActivos,
                'ventas_hoy' => (float)$ventasHoy,
                'ventas_hoy_formateado' => '$ ' . number_format($ventasHoy, 0, ',', '.') . ' COP',
                'devoluciones_pendientes' => $devolucionesPendientes,
            ],
        ]);
    }

    /**
     * Gestión de inventario general y alertas.
     */
    public function inventario(Request $request)
    {
        $query = Producto::with(['categoria', 'inventario', 'imagenPrincipal']);

        if ($request->filled('estado_stock')) {
            // Filtrar por estado
            $filtro = $request->estado_stock;
            $all = $query->get()->filter(fn ($p) => strtolower($p->estado_stock) === strtolower($filtro));
            return response()->json([
                'success' => true,
                'total' => $all->count(),
                'data' => $all->values(),
            ]);
        }

        $productos = $query->latest()->paginate(15);

        $productos->getCollection()->transform(function ($p) {
            return [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'categoria' => $p->categoria ? $p->categoria->nombre : null,
                'stock_actual' => (int)$p->stock_actual,
                'stock_reservado' => (int)$p->stock_reservado,
                'stock_disponible' => (int)$p->stock_disponible,
                'stock_minimo' => (int)$p->stock_minimo,
                'estado_stock' => $p->estado_stock,
                'precio_compra' => (float)$p->precio_compra,
                'precio_venta' => (float)$p->precio_venta,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $productos,
        ]);
    }

    /**
     * Listado del Kardex / Movimientos de inventario.
     */
    public function movimientos(Request $request)
    {
        $query = MovimientoInventario::with('producto');

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_movimiento', 'like', $request->tipo . '%');
        }

        if ($request->filled('filtro_fecha')) {
            match ($request->filtro_fecha) {
                'hoy' => $query->whereDate('fecha_movimiento', Carbon::today()),
                'semana' => $query->whereBetween('fecha_movimiento', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
                'mes' => $query->whereMonth('fecha_movimiento', Carbon::now()->month)->whereYear('fecha_movimiento', Carbon::now()->year),
                default => null,
            };
        }

        $movimientos = $query->latest('fecha_movimiento')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $movimientos,
        ]);
    }

    /**
     * Registrar un movimiento manual de inventario (Entrada por compra o Salida por ajuste).
     */
    public function registrarMovimiento(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo_movimiento' => 'required|in:Entrada,Salida,Ajuste',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string',
        ]);

        $producto = Producto::with('inventario')->findOrFail($request->producto_id);
        $cantidad = (int)$request->cantidad;
        $tipo = $request->tipo_movimiento;

        $inventario = $producto->inventario ?? Inventario::create([
            'producto_id' => $producto->id,
            'stock_actual' => $producto->stock_actual,
            'stock_reservado' => 0,
            'stock_disponible' => $producto->stock_actual,
        ]);

        $stockAnterior = $inventario->stock_actual;

        if ($tipo === 'Entrada') {
            $inventario->stock_actual += $cantidad;
            $inventario->stock_disponible += $cantidad;
            $producto->stock_actual += $cantidad;
            $tipoTexto = 'Entrada - Manual';
        } else {
            if ($cantidad > $inventario->stock_disponible) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes retirar más del stock disponible actual (' . $inventario->stock_disponible . ').',
                ], 422);
            }
            $inventario->stock_actual -= $cantidad;
            $inventario->stock_disponible -= $cantidad;
            $producto->stock_actual -= $cantidad;
            $tipoTexto = 'Salida - Manual';
        }

        $inventario->fecha_actualizacion = now();
        $inventario->save();
        $producto->save();

        $movimiento = MovimientoInventario::create([
            'producto_id' => $producto->id,
            'tipo_movimiento' => $tipoTexto,
            'cantidad' => $cantidad,
            'stock_anterior' => $stockAnterior,
            'stock_nuevo' => $inventario->stock_actual,
            'fecha_movimiento' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Movimiento registrado exitosamente.',
            'movimiento' => $movimiento,
            'stock_actual' => $inventario->stock_actual,
            'stock_disponible' => $inventario->stock_disponible,
        ]);
    }

    /**
     * Listar todos los pedidos para el panel de administración.
     */
    public function pedidos(Request $request)
    {
        $query = Pedido::with(['user', 'direccion', 'informacionEnvio', 'pago', 'detalles.producto']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('numero_pedido', 'like', "%{$s}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"));
            });
        }

        $pedidos = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $pedidos,
        ]);
    }

    /**
     * Actualizar estado de un pedido (Activo, En preparación, Enviado, Entregado, Cancelado).
     */
    public function updatePedidoEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
        ]);

        $pedido = Pedido::with('detalles')->findOrFail($id);
        $anteriorEstado = $pedido->estado;
        $pedido->estado = $request->estado;
        $pedido->save();

        // Si se marca Entregado, liberar reservas y descontar stock actual físico
        if ($request->estado === 'Entregado' && $anteriorEstado !== 'Entregado') {
            foreach ($pedido->detalles as $det) {
                $inv = Inventario::where('producto_id', $det->producto_id)->first();
                if ($inv) {
                    $inv->stock_actual -= $det->cantidad;
                    $inv->stock_reservado = max(0, $inv->stock_reservado - $det->cantidad);
                    $inv->save();

                    $prod = Producto::find($det->producto_id);
                    if ($prod) {
                        $prod->stock_actual = $inv->stock_actual;
                        $prod->save();
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Estado del pedido actualizado.',
            'pedido' => $pedido,
        ]);
    }

    /**
     * Gestión de envíos de pedidos.
     */
    public function envios(Request $request)
    {
        $query = Pedido::with(['informacionEnvio', 'user', 'direccion']);

        if ($request->filled('estado')) {
            $est = $request->estado;
            $query->whereHas('informacionEnvio', fn ($q) => $q->where('estado', $est));
        }

        $pedidos = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $pedidos,
        ]);
    }

    /**
     * Actualizar información de envío de un pedido.
     */
    public function updateEnvio(Request $request, $pedido_id)
    {
        $pedido = Pedido::findOrFail($pedido_id);

        $validated = $request->validate([
            'estado' => 'required|string',
            'transportadora' => 'nullable|string',
            'fecha_envio' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
        ]);

        $envio = InformacionEnvio::updateOrCreate(
            ['pedido_id' => $pedido->id],
            [
                'estado' => $validated['estado'],
                'transportadora' => $validated['transportadora'] ?? 'Servientrega',
                'fecha_envio' => $validated['fecha_envio'] ?? now(),
                'fecha_entrega' => $validated['fecha_entrega'] ?? null,
                'ciudad' => $pedido->direccion->municipio ?? 'Ciudad',
                'direccion' => $pedido->direccion->direccion ?? 'Dirección',
            ]
        );

        if ($validated['estado'] === 'Entregado') {
            $pedido->estado = 'Entregado';
            $pedido->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Información de envío actualizada.',
            'envio' => $envio,
        ]);
    }

    /**
     * Listado de solicitudes de devolución.
     */
    public function devoluciones(Request $request)
    {
        $query = Devolucion::with(['pedido', 'user']);

        if ($request->filled('estado')) {
            $query->where('estado', strtoupper($request->estado));
        }

        $devoluciones = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $devoluciones,
        ]);
    }

    /**
     * Aprobar o rechazar devolución.
     */
    public function updateDevolucion(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:APROBADA,RECHAZADA',
        ]);

        $devolucion = Devolucion::with('pedido')->findOrFail($id);
        $devolucion->estado = $request->estado;
        $devolucion->save();

        if ($devolucion->pedido) {
            $devolucion->pedido->estado = ($request->estado === 'APROBADA') ? 'Devuelto' : 'Entregado';
            $devolucion->pedido->save();
        }

        return response()->json([
            'success' => true,
            'message' => "Devolución {$request->estado} exitosamente.",
            'devolucion' => $devolucion,
        ]);
    }

    /**
     * Reporte y resumen de ventas.
     */
    public function ventas(Request $request)
    {
        $filtro = $request->query('filtro', 'todo');
        $query = Pedido::with(['user', 'detalles.producto'])
            ->where('estado', 'Entregado');

        match ($filtro) {
            'hoy' => $query->whereDate('created_at', Carbon::today()),
            'semana' => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'mes' => $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year),
            'ano' => $query->whereYear('created_at', Carbon::now()->year),
            default => null,
        };

        $totalIngresos = (clone $query)->sum('total');
        $ventasPaginadas = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'filtro' => $filtro,
            'total_ingresos' => (float)$totalIngresos,
            'total_ingresos_formateado' => '$ ' . number_format($totalIngresos, 0, ',', '.') . ' COP',
            'data' => $ventasPaginadas,
        ]);
    }

    /**
     * Proveedores listado para administración.
     */
    public function proveedores()
    {
        $proveedores = Proveedor::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $proveedores,
        ]);
    }
}

