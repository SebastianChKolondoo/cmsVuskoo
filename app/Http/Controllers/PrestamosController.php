<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use App\Models\CategoriasPrestamos;
use App\Models\Paises;
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
        $categorias = CategoriasPrestamos::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });
        return view('prestamos.create', compact('states', 'operadorasList', 'categorias', 'prestadoras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $empresa = Banca::find($request->banca);
        $pais = $empresa->pais;
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
            'estado' => $request->estado,
            'categoria' => $request->categoria,
            'pais' => $pais
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
        $categorias = CategoriasPrestamos::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });
        return view('prestamos.edit', compact('tarifa', 'categorias', 'operadorasList', 'states', 'prestadoras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empresa = Banca::find($request->banca);
        $pais = $empresa->pais;
        
        $request['pais'] = $pais;
        
        $tarifa = Prestamos::find($id);
        $tarifa->update($request->all());
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
