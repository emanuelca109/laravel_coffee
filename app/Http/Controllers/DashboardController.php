<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{    //ESTO SE PONE PARA QUE SI ES ROL 1 VAYA DASHBOARD ADMIN SINO PARA CLIENTE
    public function welcome()
    {
        if (auth()->check() && auth()->user()->role_id == 1) {
            $usuarios = \App\Models\User::count();
            $ingresos = \App\Models\Pedido::where('estado', 'Entregado')->sum('total');
            $stockBajo = \App\Models\Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();
            $productos = \App\Models\Producto::count();

            return view('admin.dashboard', compact('usuarios', 'ingresos', 'stockBajo', 'productos'));
        }

        return redirect()->route('inicio');
    }
    
}
