<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devolucion;
use Illuminate\Http\Request;

class DevolucionController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        $pendientes = Devolucion::where('estado', 'PENDIENTE')->count();
        $aprobadas = Devolucion::where('estado', 'APROBADA')->count();
        $rechazadas = Devolucion::where('estado', 'RECHAZADA')->count();

        $query = Devolucion::with(['pedido', 'user'])->latest();

        if ($estado && in_array($estado, ['PENDIENTE', 'APROBADA', 'RECHAZADA'])) {
            $query->where('estado', $estado);
        }
        $devoluciones = $query->paginate(10);
        return view('admin.devoluciones.index', compact('devoluciones', 'pendientes', 'aprobadas', 'rechazadas', 'estado'));
    }

    public function update(Request $request, Devolucion $devolucion)
    {
        $request->validate([
            'estado' => 'required|in:APROBADA,RECHAZADA',
        ]);

        $devolucion->estado = $request->estado;
        $devolucion->save();
        
        // También actualizamos el estado del pedido
        $pedido = $devolucion->pedido;
        if ($request->estado == 'APROBADA') {
            $pedido->estado = 'Devuelto';
        } elseif ($request->estado == 'RECHAZADA') {
            $pedido->estado = 'Entregado';
        }
        $pedido->save();

        return redirect()->back()->with('success', 'El estado de la solicitud ha sido actualizado correctamente.');
    }
}
