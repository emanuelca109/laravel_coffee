<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::paginate(10);
        return view('admin.proveedor.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Proveedor::create([

            'nombre_empresa' => $request->nombre_empresa,

            'nombre_proveedor' => $request->nombre_proveedor,

            'telefono' => $request->telefono,

            'correo' => $request->correo,

            'direccion' => $request->direccion,

            'estado' => $request->estado

        ]);

        return redirect()
                ->route('proveedores.index')
                ->with('success', 'Proveedor creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update([

            'nombre_empresa' => $request->nombre_empresa,

            'nombre_proveedor' => $request->nombre_proveedor,

            'telefono' => $request->telefono,

            'correo' => $request->correo,

            'direccion' => $request->direccion,

            'estado' => $request->estado

        ]);

        return redirect()
                ->route('proveedores.index')
                ->with('success', 'Proveedor actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Proveedor::findOrFail($id)->delete();

        return redirect()
                ->route('proveedores.index')
                ->with('success', 'Proveedor eliminado correctamente');
    }
}