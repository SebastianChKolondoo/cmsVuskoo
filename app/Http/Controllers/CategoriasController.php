<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Paises;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorias::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = Paises::all();
        return view('categorias.create', compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        // Iterar sobre cada elemento del request
        foreach ($data as $key => $value) {
            $codigoPais = explode('_', $key)[1];
            // Guardar la categoría
            if(!empty($value)){
                Categorias::create([
                    'categoria' => $value,
                    'nombre' => $value,
                    'pais' => $codigoPais,
                ]);
            }
        }
        return redirect()->route('categorias.index')->with('info', 'Categoria creada correctamente.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
