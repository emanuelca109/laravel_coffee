<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::withCount('productos')->paginate(10);
        
        return view('admin.categorias.index', compact('categorias'));
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
        
        Categoria::create([

            'nombre' => $request->nombre,

            'descripcion' => $request->descripcion,

            'estado' => $request->estado

        ]);

        return redirect()
                ->route('categorias.index')
                ->with('success', 'Categoría creada correctamente');
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
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->update([

            'nombre' => $request->nombre,

            'descripcion' => $request->descripcion,

            'estado' => $request->estado

        ]);

        return redirect()
                ->route('categorias.index')
                ->with('success','Categoría actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categoria::findOrFail($id)->delete();

        return redirect()
                ->route('categorias.index')
                ->with('success','Categoría eliminada');
    }
}
