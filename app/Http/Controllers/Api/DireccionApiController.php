<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionApiController extends Controller
{
    /**
     * Listar las direcciones guardadas del cliente.
     */
    public function index(Request $request)
    {
        $direcciones = Direccion::where('cliente_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $direcciones,
        ]);
    }

    /**
     * Guardar una nueva dirección de entrega.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_direccion' => 'required|string|max:255',
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
            'referencias' => 'nullable|string',
        ]);

        $validated['cliente_id'] = $request->user()->id;

        $direccion = Direccion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dirección creada exitosamente',
            'data' => $direccion,
        ], 201);
    }

    /**
     * Ver una dirección en específico.
     */
    public function show(Request $request, $id)
    {
        $direccion = Direccion::where('cliente_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $direccion,
        ]);
    }

    /**
     * Actualizar una dirección existente.
     */
    public function update(Request $request, $id)
    {
        $direccion = Direccion::where('cliente_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'nombre_direccion' => 'required|string|max:255',
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
            'referencias' => 'nullable|string',
        ]);

        $direccion->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dirección actualizada exitosamente',
            'data' => $direccion,
        ]);
    }

    /**
     * Eliminar una dirección.
     */
    public function destroy(Request $request, $id)
    {
        $direccion = Direccion::where('cliente_id', $request->user()->id)
            ->findOrFail($id);

        $direccion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dirección eliminada correctamente.',
        ]);
    }
}

