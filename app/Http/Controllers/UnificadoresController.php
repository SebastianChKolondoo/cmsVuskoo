<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use App\Models\CategoriasPrestamos;
use App\Models\EmisorBanca;
use App\Models\Prestamos;
use App\Models\States;
use App\Models\Unificadores;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnificadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = Prestamos::whereIn('categoria',[4])->get();
        return view('unificadoras.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $prestadoras = Banca::all();
        $categorias = CategoriasPrestamos::whereIn('id', [4])->get();
        $emisor = EmisorBanca::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });
        return view('unificadoras.create', compact('states', 'operadorasList', 'categorias', 'prestadoras', 'emisor'));
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
            'categoria' => 4,
            'pais' => $pais,
            'interes_mensual' => $request->interes_mensual,
            'inteses_anual' => $request->inteses_anual,
            'ingresos_minimos' => $request->ingresos_minimos,
            'slug_tarifa' => Str::slug($request->slug_tarifa),
        ]);
        return redirect()->route('prestamos.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unificadores $unificadores)
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
        $categorias = CategoriasPrestamos::whereIn('id', [4])->get();
        $emisor = EmisorBanca::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });
        return view('unificadoras.edit', compact('tarifa', 'categorias', 'operadorasList', 'states', 'prestadoras', 'emisor'));
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(Request $request, $id)
    {
        $empresa = Banca::find($request->banca);
        $pais = $empresa->pais;

        $request['pais'] = $pais;
        $request['categoria'] = 4;
        $request['slug_tarifa'] = Str::slug($request->slug_tarifa);
        $tarifa = Prestamos::find($id);
        $tarifa->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
    } */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unificadores $unificadores)
    {
        //
    }
}
