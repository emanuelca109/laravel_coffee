<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class InventarioController extends Controller
{
    public function index()
    {
        $allProductos = Producto::get();
        $totalProductos = $allProductos->count();

        $alertas = $allProductos->filter(function ($producto) {
            return $producto->estado_stock !== 'Disponible';
        })->count();

        $productos = Producto::with(['categoria', 'inventario'])->paginate(10);

        return view('admin.inventario.index', compact('productos', 'totalProductos', 'alertas'));
    }
}