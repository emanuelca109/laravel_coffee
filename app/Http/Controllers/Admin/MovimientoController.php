<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovimientoInventario;
use App\Models\Inventario;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimientoInventario::with('producto');

        // Filtro por búsqueda
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('producto', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%');
            });
        }

        // Filtros de fecha simples (hoy, semana, mes, año)
        if ($request->has('filtro')) {
            switch ($request->filtro) {
                case 'hoy':
                    $query->whereDate('fecha_movimiento', today());
                    break;
                case 'semana':
                    $query->whereBetween('fecha_movimiento', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'mes':
                    $query->whereMonth('fecha_movimiento', now()->month)
                          ->whereYear('fecha_movimiento', now()->year);
                    break;
                case 'ano':
                    $query->whereYear('fecha_movimiento', now()->year);
                    break;
            }
        }

        // Clonar la consulta base para las métricas (con búsqueda y fechas, pero SIN filtro de tipo)
        $queryBase = clone $query;

        // Filtro por tipo de movimiento (clic en las tarjetas)
        if ($request->has('tipo')) {
            switch ($request->tipo) {
                case 'entrada':
                    $query->where('tipo_movimiento', 'like', 'Entrada%');
                    break;
                case 'salida':
                    $query->where('tipo_movimiento', 'like', 'Salida%')
                          ->where('tipo_movimiento', 'not like', '%Reserva%');
                    break;
                case 'reserva':
                    $query->where('tipo_movimiento', 'like', '%Reserva%');
                    break;
            }
        }

        $movimientos = $query->orderBy('fecha_movimiento', 'desc')->paginate(10);

        // Métricas aplicando los filtros actuales (fechas y búsqueda)
        $totalMovimientos = (clone $queryBase)->count();
        
        $entradas = (clone $queryBase)->where('tipo_movimiento', 'like', 'Entrada%')->count();
        
        $salidas = (clone $queryBase)->where('tipo_movimiento', 'like', 'Salida%')
                                     ->where('tipo_movimiento', 'not like', '%Reserva%')->count();
        
        $reservas = (clone $queryBase)->where('tipo_movimiento', 'like', '%Reserva%')->count();

        return view('admin.movimiento.index', compact(
            'movimientos', 
            'totalMovimientos', 
            'entradas', 
            'salidas', 
            'reservas'
        ));
    }
}
