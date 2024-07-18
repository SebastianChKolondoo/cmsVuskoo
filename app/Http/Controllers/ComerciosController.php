<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comercios;
use App\Models\Paises;
use App\Models\States;
use Illuminate\Http\Request;

class ComerciosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:comercios.view')->only('index');
        $this->middleware('can:comercios.view.btn-create')->only('create', 'store');
        $this->middleware('can:comercios.view.btn-edit')->only('edit', 'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comercios = Comercios::all();
        return view('clientes.comercios.index', compact('comercios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = Paises::all();
        $estados =  States::all();
        return view('clientes.comercios.create', compact('estados', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permisos = Comercios::create([
            'nombre' => ($request->name),
            'tipo_conversion' => '',
            'color' => '',
            'color_texto' => '',
            'logo' => ($request->logo),
            'logo_negativo' => ($request->negativo),
            'isotipo' => '',
            'politica_privacidad' => ($request->politica),
            'estado' => ($request->state),
            'fecha_registro' => now(),
            'categoria' => $request->categoria
        ]);

        return redirect()->route('comercios.index')->with('info', 'comercio creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comercios $comercios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comercio = Comercios::find($id);
        $array = json_decode($comercio->pais, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $array = array_map('intval', $array);
            $comercio->pais = $array;
        }
        $paises = Paises::all();
        $estados = States::all();
        $categorias = Categorias::all();
        return view('clientes.comercios.edit', compact('comercio', 'estados', 'paises', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $comercio)
    {
        $comercios = Comercios::find($comercio);
        $comercios->update($request->all());
        return redirect()->route('comercios.index')->with('info', 'comercio editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comercios $comercios)
    {
        //
    }
}
