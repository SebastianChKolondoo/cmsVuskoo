<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use App\Models\States;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paises = Paises::all();
        return view('pais.index', compact('paises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Paises::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'moneda' => $request->moneda,
            'lang' => $request->lang,
            'locale' => $request->locale,
            'language' => $request->language,
            'geo_region' => $request->geo_region,
            'geo_position' => $request->geo_position,
            'geo_placename' => $request->geo_placename,
        ]);
        return redirect()->route('paises.index')->with('info', 'Pais creado correctamente.');
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
    public function edit($id)
    {
        $pais = Paises::find($id);
        $estados = States::all();
        return view('pais.edit', compact('pais', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $pais = Paises::find($id);
        $pais->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
