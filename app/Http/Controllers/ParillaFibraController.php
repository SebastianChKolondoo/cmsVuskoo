<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\ParillaFibra;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaFibraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaFibra::all();
        return view('telefonia.movil.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.movil.create', compact('states', 'operadoras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = ['es' => '€', 'co' => '$'];
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $tarifa = ParillaFibra::create([
            'operadora' => $request->operadora,
            'estado' => $request->estado,
            'nombre_tarifa' => $request->nombre_tarifa,
            'parrilla_bloque_1' => trim(str_replace('  ', ' ', $request->parrilla_bloque_1)),
            'parrilla_bloque_2' => trim(str_replace('  ', ' ', $request->parrilla_bloque_2)),
            'parrilla_bloque_3' => trim(str_replace('  ', ' ', $request->parrilla_bloque_3)),
            'parrilla_bloque_4' => trim(str_replace('  ', ' ', $request->parrilla_bloque_4)),
            'meses_permanencia' => $request->meses_permanencia,
            'precio' => $request->precio,
            'precio_final' => $request->precio_final,
            'num_meses_promo' => $request->num_meses_promo,
            'promocion' => $request->promocion,
            'GB' => $request->GB,
            'coste_llamadas_minuto' => $request->coste_llamadas_minuto,
            'coste_establecimiento_llamada' => $request->coste_establecimiento_llamada,
            'num_minutos_gratis' => $request->num_minutos_gratis,
            'fecha_expiracion' => $request->fecha_expiracion,
            'moneda' => $moneda[$request->pais],
            'slug_tarifa' => $slug,
            'pais' => $request->pais
        ]);

        return redirect()->route('ParillaFibra.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaFibra $parillaMovil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaMovil)
    {
        $tarifa = ParillaFibra::find($parillaMovil);
        $states = States::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.movil.edit', compact('tarifa', 'states', 'operadoras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaMovil)
    {
        $tarifa = ParillaFibra::find($parillaMovil);
        $tarifa->update($request->all());
        return redirect()->route('ParillaFibra.index')->with('info', 'Tarifa editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParillaFibra $parillaMovil)
    {
        //
    }
}
