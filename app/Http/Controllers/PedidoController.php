<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $estado = $request->get('estado');

        // Obtener todos los pedidos con su usuario asociado, aplicando el filtro si existe
        $query = Pedido::with('user')->latest();

        if ($estado) {
            // Manejar 'Pendiente' que también incluye 'Activo'
            if ($estado === 'Pendiente') {
                $query->whereIn('estado', ['Activo', 'Pendiente']);
            } else {
                $query->where('estado', $estado);
            }
        }
        $pedidos = $query->paginate(10);
        // Calcular métricas (basado en TODOS los pedidos, no solo los filtrados)
        $todos = Pedido::all();
        $total = $todos->count();
        $pendientes = $todos->whereIn('estado', ['Activo', 'Pendiente'])->count();
        $enProceso = $todos->where('estado', 'En Proceso')->count();
        $enviados = $todos->where('estado', 'Enviado')->count();
        $entregados = $todos->where('estado', 'Entregado')->count();

        $filtroActual = $estado;

        return view('admin.pedidos.index', compact('pedidos', 'total', 'pendientes', 'enProceso', 'enviados', 'entregados', 'filtroActual'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedido::with(['user', 'detalles.producto', 'direccion', 'pago'])->findOrFail($id);
        
        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Activo,En Proceso,Enviado,Entregado'
        ]);

        $pedido = Pedido::with('detalles.producto.inventario')->findOrFail($id);
        $oldEstado = $pedido->estado;
        
        $pedido->estado = $request->estado;
        $pedido->save();

        if ($pedido->informacionEnvio) {
            $pedido->informacionEnvio->update([
                'estado' => $request->estado
            ]);
        }

        // Lógica de inventario al cambiar de estado
        if ($oldEstado !== 'Entregado' && $request->estado === 'Entregado') {
            // El pedido se completó (es una venta). Descontamos el stock reservado y el físico.
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto && $detalle->producto->inventario) {
                    $inventario = $detalle->producto->inventario;
                    
                    // Descontar del reservado (evitando negativos si hubo inconsistencias)
                    if ($inventario->stock_reservado >= $detalle->cantidad) {
                        $inventario->stock_reservado -= $detalle->cantidad;
                    } else {
                        // En caso de inconsistencia previa, no bajar de 0
                        $inventario->stock_reservado = 0;
                    }
                    
                    // Descontar del stock actual físico
                    $inventario->stock_actual -= $detalle->cantidad;
                    
                    // Forzar que stock_disponible siempre sea correcto
                    $inventario->stock_disponible = $inventario->stock_actual - $inventario->stock_reservado;
                    $inventario->save();

                    // También actualizamos en la tabla de productos
                    $producto = $detalle->producto;
                    $oldStock = $producto->stock_actual; // Same as before update
                    $producto->stock_actual -= $detalle->cantidad;
                    $producto->save();

                    MovimientoInventario::create([
                        'producto_id' => $producto->id,
                        'tipo_movimiento' => 'Salida - Venta',
                        'cantidad' => $detalle->cantidad,
                        'stock_anterior' => $oldStock,
                        'stock_nuevo' => $producto->stock_actual,
                        'fecha_movimiento' => now()
                    ]);
                }
            }
        } elseif ($oldEstado === 'Entregado' && $request->estado !== 'Entregado') {
            // Si por error se marcó como Entregado y se regresa a Pendiente, restauramos el inventario
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto && $detalle->producto->inventario) {
                    $inventario = $detalle->producto->inventario;
                    $inventario->stock_reservado += $detalle->cantidad;
                    $inventario->stock_actual += $detalle->cantidad;
                    $inventario->stock_disponible = $inventario->stock_actual - $inventario->stock_reservado;
                    $inventario->save();

                    $producto = $detalle->producto;
                    $oldStock = $producto->stock_actual;
                    $producto->stock_actual += $detalle->cantidad;
                    $producto->save();

                    MovimientoInventario::create([
                        'producto_id' => $producto->id,
                        'tipo_movimiento' => 'Entrada - Devolución',
                        'cantidad' => $detalle->cantidad,
                        'stock_anterior' => $oldStock,
                        'stock_nuevo' => $producto->stock_actual,
                        'fecha_movimiento' => now()
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'El estado del pedido ha sido actualizado correctamente.');
    }
}
