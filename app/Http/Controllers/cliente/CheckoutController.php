<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Direccion;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function procesar(Request $request)
    {
        $request->validate([
            'direccion_id' => 'nullable|exists:direcciones,id',
            'direccion' => 'nullable|string',
            'municipio' => 'nullable|string',
            'telefono' => 'nullable|string',
            'metodo_pago' => 'required|string',
        ]);

        $user = auth()->user();
        $modo = $request->input('modo');

        if ($modo === 'directo') {
            $carritoSession = session('compra_directa', []);
        } else {
            $carritoSession = session('carrito', []);
        }

        if (empty($carritoSession)) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío.');
        }

        // Obtener o crear dirección
        $direccion_id = $request->direccion_id;

        if (!$direccion_id && $request->direccion) {
            $direccion = Direccion::create([
                'cliente_id' => $user->id,
                'direccion' => $request->direccion,
                'municipio' => $request->municipio ?? 'Ciudad',
                'telefono' => $request->telefono ?? '000000',
                'nombre_direccion' => $request->nombre_direccion ?? 'Casa',
                'nombre_completo' => $request->nombre_completo ?? $user->name,
                'departamento' => $request->departamento ?? 'No especificado',
                'codigo_postal' => $request->codigo_postal ?? '00000',
                'referencias' => $request->referencias ?? '',
            ]);
            $direccion_id = $direccion->id;
        }

        if (!$direccion_id) {
            return back()->with('error', 'Debes seleccionar o ingresar una dirección válida.');
        }

        // Recuperar productos de la BD para calcular totales reales
        $ids = array_keys($carritoSession);
        $productos = \App\Models\Producto::whereIn('id', $ids)->get()->keyBy('id');

        $total = 0;
        $cantidadTotal = 0;
        $detalles = [];

        foreach ($carritoSession as $id => $item) {
            if (!isset($productos[$id])) continue;
            
            $producto = $productos[$id];
            $cantidad = $item['cantidad'];
            $subtotal = $producto->precio_venta * $cantidad;

            $total += $subtotal;
            $cantidadTotal += $cantidad;

            $detalles[] = [
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio_venta,
                'subtotal' => $subtotal,
            ];
        }

        // Crear el Pedido
        $pedido = Pedido::create([
            'user_id' => $user->id,
            'direccion_id' => $direccion_id,
            'numero_productos' => $cantidadTotal,
            'fecha' => now(),
            'estado' => 'Activo',
            'total' => $total,
            'numero_pedido' => 'PED-' . strtoupper(Str::random(8)),
        ]);

        // Crear los Detalles del Pedido y actualizar inventario
        foreach ($detalles as $detalle) {
            $detalle['pedido_id'] = $pedido->id;
            DetallePedido::create($detalle);
            
            $inventario = \App\Models\Inventario::where('producto_id', $detalle['producto_id'])->first();
            if ($inventario) {
                $inventario->stock_reservado += $detalle['cantidad'];
                $inventario->stock_disponible -= $detalle['cantidad'];
                $inventario->save();
                
                MovimientoInventario::create([
                    'producto_id' => $detalle['producto_id'],
                    'tipo_movimiento' => 'Salida - Reserva',
                    'cantidad' => $detalle['cantidad'],
                    'stock_anterior' => $inventario->stock_actual,
                    'stock_nuevo' => $inventario->stock_actual, // No cambia el stock físico
                    'fecha_movimiento' => now()
                ]);
            }
        }

        // Registrar el Pago
        Pago::create([
            'pedido_id' => $pedido->id,
            'monto' => $total,
            'metodo_pago' => $request->metodo_pago,
            'estado_pago' => 'Pendiente',
            'fecha_pago' => now(),
            'factura' => 'FACT-' . strtoupper(Str::random(6)),
        ]);

        // Vaciar la sesión correspondiente
        if ($modo === 'directo') {
            session()->forget('compra_directa');
        } else {
            session()->forget('carrito');
            if (auth()->check()) {
                $user = auth()->user();
                $user->carrito = null;
                $user->save();
            }
        }
        
        session()->forget('iniciar_compra');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'pedido_id' => $pedido->id,
                'numero_pedido' => $pedido->numero_pedido,
            ]);
        }

        return redirect()->route('checkout.exito', $pedido->id);
    }

    public function exito(Pedido $pedido)
    {
        if ($pedido->user_id !== auth()->id()) {
            abort(403);
        }

        return view('cliente.checkout.success', compact('pedido'));
    }
}
