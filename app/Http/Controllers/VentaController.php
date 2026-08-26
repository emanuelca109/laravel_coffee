<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('filtro', 'todo');
        $query = Pedido::with(['user', 'detalles.producto', 'direccion'])
                       ->where('estado', 'Entregado');
        
        switch ($filtro) {
            case 'hoy':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'semana':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'ano':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
            default:
                break;
        }

        $todasVentas = (clone $query)->get();
        
        $ventasCompletadas = $todasVentas->count();
        $ingresosTotales = 0;
        $costoTotal = 0;

        foreach ($todasVentas as $venta) {
            $ingresosTotales += $venta->total;
            foreach ($venta->detalles as $detalle) {
                if ($detalle->producto) {
                    $costoTotal += $detalle->producto->precio_compra * $detalle->cantidad;
                }
            }
        }

        $ventas = $query->latest()->paginate(10);

        foreach ($ventas as $venta) {
            $costoVenta = 0;
            foreach ($venta->detalles as $detalle) {
                $precioCompra = $detalle->producto ? $detalle->producto->precio_compra : 0;
                $costoVenta += ($precioCompra * $detalle->cantidad);
            }
            $venta->costo_compra_calculado = $costoVenta;
            $venta->ganancia_calculada = $venta->total - $costoVenta;
            
            $margen = 0;
            if ($venta->total > 0) {
                $margen = ($venta->ganancia_calculada / $venta->total) * 100;
            }
            $venta->margen_calculado = $margen;
        }

        $gananciaNeta = $ingresosTotales - $costoTotal;
        
        $margenTotal = 0;
        if ($ingresosTotales > 0) {
            $margenTotal = ($gananciaNeta / $ingresosTotales) * 100;
        }

        // Distribución porcentajes
        $porcentajeCosto = 0;
        $porcentajeGanancia = 0;
        if ($ingresosTotales > 0) {
            $porcentajeCosto = ($costoTotal / $ingresosTotales) * 100;
            $porcentajeGanancia = ($gananciaNeta / $ingresosTotales) * 100;
        }

        return view('admin.ventas.index', compact(
            'ventas', 
            'filtro', 
            'ventasCompletadas', 
            'ingresosTotales', 
            'costoTotal', 
            'gananciaNeta', 
            'margenTotal',
            'porcentajeCosto',
            'porcentajeGanancia'
        ));
    }
}
