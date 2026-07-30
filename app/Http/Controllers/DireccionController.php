<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use Illuminate\Support\Facades\Auth;

class DireccionController extends Controller
{
    public function index()
    {
        $direcciones = Direccion::where('cliente_id', Auth::id())->get();
        return view('cliente.direcciones.index', compact('direcciones'));
    }

    public function create()
    {
        return view('cliente.direcciones.create');
    }

    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nombre_direccion' => 'required|string|max:255',
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'codigo_postal' => 'nullable|string|max:255',
            'referencias' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->has('from_checkout')) {
                if ($request->has('direct_buy')) {
                    return redirect()->back()->withErrors($validator)->withInput()->with([
                        'iniciar_compra' => true,
                        'modo' => 'directo',
                        'direct_producto_id' => $request->producto_id,
                        'show_form_nueva_dir' => true
                    ]);
                }
                return redirect()->route('carrito')->withErrors($validator)->withInput()->with([
                    'iniciar_compra' => true,
                    'show_form_nueva_dir' => true
                ]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Direccion::create([
            'cliente_id' => Auth::id(),
            'nombre_direccion' => $request->nombre_direccion,
            'nombre_completo' => $request->nombre_completo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'departamento' => $request->departamento,
            'municipio' => $request->municipio,
            'codigo_postal' => $request->codigo_postal,
            'referencias' => $request->referencias,
        ]);

        if ($request->has('from_checkout')) {
            if ($request->has('direct_buy')) {
                return redirect()->back()->with([
                    'iniciar_compra' => true,
                    'modo' => 'directo',
                    'direct_producto_id' => $request->producto_id,
                    'success' => 'Dirección agregada correctamente.'
                ]);
            }
            return redirect()->route('carrito')->with('iniciar_compra', true)->with('success', 'Dirección agregada correctamente.');
        }

        return redirect()->route('direcciones.index')->with('success', 'Dirección agregada correctamente.');
    }

    public function edit(Direccion $direccion)
    {
        if ($direccion->cliente_id !== Auth::id()) {
            abort(403);
        }
        return view('cliente.direcciones.edit', compact('direccion'));
    }

    public function update(Request $request, Direccion $direccion)
    {
        if ($direccion->cliente_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nombre_direccion' => 'required|string|max:255',
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'codigo_postal' => 'nullable|string|max:255',
            'referencias' => 'nullable|string',
        ]);

        $direccion->update($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'direccion' => $direccion
            ]);
        }

        if ($request->has('from_checkout')) {
            return redirect()->back()->with('iniciar_compra', true)->with('success', 'Dirección actualizada correctamente.');
        }

        return redirect()->route('direcciones.index')->with('success', 'Dirección actualizada correctamente.');
    }

    public function destroy(Direccion $direccion)
    {
        if ($direccion->cliente_id !== Auth::id()) {
            abort(403);
        }
        $direccion->delete();
        return redirect()->route('direcciones.index')->with('success', 'Dirección eliminada correctamente.');
    }
}
