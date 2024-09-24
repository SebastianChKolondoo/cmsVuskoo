<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comercios;
use App\Models\Paises;
use App\Models\States;
use App\Models\TipoCupon;
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
        $estados = States::all();
        $categorias = Categorias::all();
        $tipoCupon = TipoCupon::all();
        return view('clientes.comercios.create', compact('estados', 'paises','categorias','tipoCupon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permisos = Comercios::create([
            'nombre' => ($request->name),
            'nombre_slug' => $request->nombre_slug,
            'idPerseo' => $request->idPerseo,
            'logo' => ($request->logo),
            'logo_negativo' => ($request->negativo),
            'politica_privacidad' => ($request->politica),
            'fecha_registro' => now(),
            'categoria' => $request->categoria,
            'estado' => ($request->state),
            'pais' => $request->pais,
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
        $paises = Paises::all();
        $estados = States::all();
        $categorias = Categorias::all();
        $tipoCupon = TipoCupon::all();
        return view('clientes.comercios.edit', compact('tipoCupon','comercio', 'estados', 'paises', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $comercio)
    {
        $comercios = Comercios::find($comercio);
        $comercios->update($request->all());
        //return back()->with('info', 'Información actualizada correctamente.');
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
