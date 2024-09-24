<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Paises;
use App\Models\TraduccionCategorias;
use Illuminate\Http\Request;

class TraduccionCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Categorias::all();
        return view('traduccionCategorias.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Paises::all();
        return view('traduccionCategorias.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $codigoPais = explode('_', $key)[1];
            // Guardar la categoría
            if(!empty($value)){
                Categorias::create([
                    'categoria' => $value,
                    'nombre' => strtolower($value),
                    'pais' => $codigoPais,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TraduccionCategorias $traduccionCategorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categorias::find($id);
        $paises = Paises::all();
        foreach($paises as $pais){
            $validacion = TraduccionCategorias::where('categoria',$id)->where('pais',$pais->id)->count();
            if($validacion == 0){
                $validacion = TraduccionCategorias::create([
                    'categoria' => $id,
                    'pais' => $pais->id
                ]);
            }
        }

        $traducciones = TraduccionCategorias::where('categoria',$id)->get();
        return view('traduccionCategorias.edit', compact('traducciones','categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data = TraduccionCategorias::find($id);
        $data->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
        //return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraduccionCategorias $traduccionCategorias)
    {
        //
    }
}
