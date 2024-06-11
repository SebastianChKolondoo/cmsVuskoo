<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use App\Models\Prestamos;
use App\Models\States;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = Prestamos::all();
        return view('prestamos.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $prestadoras = Banca::all();
        return view('prestamos.create', compact('states', 'prestadoras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Prestamos::create([
            'banca' => $request->banca,
            'titulo' => $request->titulo,
            'selector1' => $request->selector1,
            'valorMaximo' => $request->valorMaximo,
            'parrilla_1' => $request->parrilla_1,
            'parrilla_2' => $request->parrilla_2,
            'parrilla_3' => $request->parrilla_3,
            'parrilla_4' => $request->parrilla_4,
            'url_redirct' => $request->url_redirct,
            'destacada' => $request->destacada,
            'estado' => $request->estado
        ]);
        return redirect()->route('prestamos.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamos $prestamos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tarifa = Prestamos::find($id);
        $states = States::all();
        $prestadoras = Banca::all();
        return view('prestamos.edit', compact('tarifa', 'states', 'prestadoras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prestamo = Prestamos::find($id);
        $prestamo->update($request->all());
        return redirect()->route('prestamos.index')->with('info', 'Tarifa editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamos $prestamos)
    {
        //
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = Prestamos::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = Prestamos::find($duplica->id);
        return redirect()->route('prestamos.edit', ['prestamo' => $tarifa->id]);
    }
}
