<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\ParillaFibraMovil;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaFibraMovilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaFibraMovil::all();
        return view('telefonia.fibramovil.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.fibramovil.create', compact('states', 'operadoras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = ['es' => '€', 'co' => '$'];
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $tarifa = ParillaFibraMovil::create([
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

        return redirect()->route('parrillafibramovil.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaFibraMovil $parillaMovil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaMovil)
    {
        $tarifa = ParillaFibraMovil::find($parillaMovil);
        $states = States::all();
        $operadoras = Operadoras::all();
        return view('telefonia.fibramovil.edit', compact('tarifa', 'states', 'operadoras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaMovil)
    {
        $moneda = ['es' => '€', 'co' => '$'];
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $tarifa = ParillaFibraMovil::find($parillaMovil);
        $tarifa->update($request->all());
        return redirect()->route('parrillafibramovil.index')->with('info', 'Tarifa editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParillaFibraMovil $parillaMovil)
    {
        //
    }
}