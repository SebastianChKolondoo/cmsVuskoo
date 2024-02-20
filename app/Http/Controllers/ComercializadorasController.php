<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\States;
use Illuminate\Http\Request;

class ComercializadorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comercializadoras = Comercializadoras::all();
        return view('clientes.comercializadoras.index', compact('comercializadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = States::all();
        return view('clientes.comercializadoras.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permisos = Comercializadoras::create([
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
        ]);

        return redirect()->route('comercializadoras.index')->with('info', 'Comercializadora creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comercializadoras $comercializadoras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comercializadora = Comercializadoras::find($id);
        $estados = States::all();
        return view('clientes.comercializadoras.edit', compact('comercializadora','estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $comercializadora)
    {
        $comercializadoras = Comercializadoras::find($comercializadora);
        $comercializadoras->update($request->all());
        return redirect()->route('comercializadoras.index')->with('info', 'Comercializadora editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comercializadoras $comercializadoras)
    {
        //
    }
}
