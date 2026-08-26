<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformacionEnvio;
use App\Models\Pedido;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    public function index(Request $request)
    {
        // Traer todos los pedidos con su información de envío, usuario y dirección
        $query = Pedido::with(['informacionEnvio', 'user', 'direccion']);

        // Base query for metrics (without estado filter)
        $queryBase = clone $query;
        $allPedidos = $queryBase->get();

        $activos = 0;
        $pendientes = 0;
        $enProceso = 0;
        $enviados = 0;
        $entregados = 0;

        foreach ($allPedidos as $pedido) {
            $estado = $pedido->informacionEnvio ? $pedido->informacionEnvio->estado : 'Pendiente';
            
            if ($estado == 'Pendiente') $pendientes++;
            elseif ($estado == 'Activo') $activos++;
            elseif ($estado == 'En Proceso') $enProceso++;
            elseif ($estado == 'Enviado') $enviados++;
            elseif ($estado == 'Entregado') $entregados++;
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $estadoFilter = $request->estado;
            if ($estadoFilter == 'Pendiente') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('informacionEnvio')
                      ->orWhereHas('informacionEnvio', function ($q2) {
                          $q2->where('estado', 'Pendiente');
                      });
                });
            } else {
                $query->whereHas('informacionEnvio', function ($q) use ($estadoFilter) {
                    $q->where('estado', $estadoFilter);
                });
            }
        }

        $pedidos = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.envios.index', compact(
            'pedidos',
            'activos',
            'pendientes',
            'enProceso',
            'enviados',
            'entregados'
        ));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|string',
            'transportadora' => 'nullable|string',
            'fecha_envio' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
        ]);

        $info = $pedido->informacionEnvio;

        if ($info) {
            $info->update([
                'estado' => $request->estado,
                'transportadora' => $request->transportadora,
                'fecha_envio' => $request->fecha_envio,
                'fecha_entrega' => $request->fecha_entrega,
            ]);
        } else {
            // Retrieve ciudad and direccion from the Pedido's Direccion model if it exists
            $ciudad = 'No especificada';
            $direccion = 'No especificada';
            if ($pedido->direccion) {
                $ciudad = $pedido->direccion->municipio;
                $direccion = $pedido->direccion->direccion;
            }

            InformacionEnvio::create([
                'pedido_id' => $pedido->id,
                'estado' => $request->estado,
                'transportadora' => $request->transportadora ?? 'Por asignar',
                'fecha_envio' => $request->fecha_envio ?? now(),
                'fecha_entrega' => $request->fecha_entrega,
                'ciudad' => $ciudad,
                'direccion' => $direccion,
            ]);
        }

        // Actualizar el estado del pedido automáticamente
        $pedido->update([
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Estado de envío actualizado correctamente.');
    }
}
