<?php

namespace App\Http\Controllers;

use App\Models\Alarmas;
use App\Models\Paises;
use App\Models\Proveedores;
use App\Models\States;
use Illuminate\Http\Request;

class AlarmasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Alarmas::all();
        return view('seguros.alarmas.index', compact('data'));
    }

    public function create()
    {
        $estados = States::all();
        $paises = Paises::all();
        $proveedores = Proveedores::all();
        return view('seguros.alarmas.create', compact('proveedores', 'estados', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Alarmas::create([
            'proveedor' => $request->proveedor,
            'selector_1' => $request->selector_1,
            'precio_1' => $request->precio_1,
            'divisa_1' => $request->divisa_1,
            'selector_2' => $request->selector_2,
            'precio_2' => $request->precio_2,
            'divisa_2' => $request->divisa_2,
            'parrilla_1' => $request->parrilla_1,
            'parrilla_2' => $request->parrilla_2,
            'parrilla_3' => $request->parrilla_3,
            'parrilla_4' => $request->parrilla_4,
            'url_redirct' => $request->url_redirct,
            'destacada' => $request->destacada,
            'estado' => $request->estado,
            'pais' => $request->pais

        ]);

        return redirect()->route('alarmas.index')->with('info', 'Oferta creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alarmas $alarmas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $oferta = Alarmas::find($id);
        $estados = States::all();
        $proveedores = Proveedores::all();
        $paises = Paises::all();
        return view('seguros.alarmas.edit', compact('oferta', 'estados', 'paises', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $alarma)
    {
        $alarma = Alarmas::find($alarma);
        $alarma->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alarmas $alarma)
    {
        //
    }
}
