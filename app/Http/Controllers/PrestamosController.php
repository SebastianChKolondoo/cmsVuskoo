<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use App\Models\CategoriasPrestamos;
use App\Models\EmisorBanca;
use App\Models\Paises;
use App\Models\Prestamos;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $emisor = EmisorBanca::all();
        $Sino = States::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });
        return view('prestamos.create', compact('states', 'operadorasList', 'categorias', 'prestadoras', 'emisor', 'Sino'));
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
            'pais' => $pais,
            'interes_mensual' => $request->interes_mensual,
            'inteses_anual' => $request->inteses_anual,
            'ingresos_minimos' => $request->ingresos_minimos,
            'descuento_comercio' => $request->descuento_comercio,
            'apertura_cuenta' => $request->apertura_cuenta,
            'disposicion_efectivo' => $request->disposicion_efectivo,
            'cajeros' => $request->cajeros,
            'red_cajeros' => $request->red_cajeros,
            'retiros_costo' => $request->retiros_costo,
            'cashback' => $request->cashback,
            'cuota_manejo_1' => $request->cuota_manejo_1,
            'cuota_manejo_2' => $request->cuota_manejo_2,
            'cuota_manejo_3' => $request->cuota_manejo_3,
            'programa_puntos' => $request->programa_puntos,
            'emisor' => $request->emisor,
            'compras_extranjero' => $request->compras_extranjero,
            'avance_cajero' => $request->avance_cajero,
            'avance_oficina' => $request->avance_oficina,
            'reposicion_tarjeta' => $request->reposicion_tarjeta,
            'slug_tarifa' => Str::slug($request->slug_tarifa),
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
        $categorias = CategoriasPrestamos::whereIn('id', [1, 2, 3])->get();
        $emisor = EmisorBanca::all();
        $Sino = States::all();
        $operadorasList = $prestadoras->mapWithKeys(function ($prestadoras) {
            return [$prestadoras->id => $prestadoras->nombre . ' - ' . $prestadoras->paises->nombre];
        });

        switch ($tarifa->categoria) {
            case 1:
            case 2:
            case 3:
                return view('prestamos.edit', compact('tarifa', 'categorias', 'operadorasList', 'states', 'prestadoras', 'emisor', 'Sino'));
                break;
            case 4:
                return view('unificadoras.edit', compact('tarifa', 'categorias', 'operadorasList', 'states', 'prestadoras'));
                break;
            case 5:
                return view('microcreditos.edit', compact('tarifa', 'categorias', 'operadorasList', 'states', 'prestadoras'));
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empresa = Banca::find($request->banca);
        $pais = $empresa->pais;
        $request['pais'] = $pais;
        $request['slug_tarifa'] = Str::slug($request->slug_tarifa);
        $tarifa = Prestamos::find($id);
        $tarifa->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
        //return redirect()->route('prestamos.index')->with('info', 'Tarifa editada correctamente.');
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
