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
        return view('telefonia.fibra.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.fibra.create', compact('states', 'operadoras'));
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
            'MB_subida' => $request->MB_subida,
            'MB_bajada' => $request->MB_bajada,
            'tlf_fijo' => $request->tlf_fijo,
            'meses_permanencia' => $request->meses_permanencia,
            'precio' => $request->precio,
            'precio_final' => $request->precio_final,
            'num_meses_promo' => $request->num_meses_promo,
            'porcentaje_descuento' => $request->porcentaje_descuento,
            'imagen_promo' => $request->imagen_promo,
            'promocion' => $request->promocion,
            'texto_alternativo_promo' => $request->texto_alternativo_promo,
            'orden_parrilla_general' => $request->orden_parrilla_general,
            'orden_parrilla_operadora' => $request->orden_parrilla_operadora,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_expiracion' => $request->fecha_expiracion,
            'fecha_registro' => $request->fecha_registro,
            'moneda' => $moneda[$request->pais],
            'slug_tarifa' => $slug,
            'pais' => $request->pais,
        ]);

        return redirect()->route('ParillaFibra.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaFibra $parillaFibra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaFibra)
    {
        $tarifa = ParillaFibra::find($parillaFibra);
        $states = States::all();
        $operadoras = Operadoras::all();
        return view('telefonia.fibra.edit', compact('tarifa', 'states', 'operadoras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaFibra)
    {
        $moneda = ['es' => '€', 'co' => '$'];
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $tarifa = ParillaFibra::find($parillaFibra);
        $tarifa->update($request->all());
        return redirect()->route('parrillafibra.index')->with('info', 'Tarifa editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParillaFibra $parillaFibra)
    {
        //
    }
}
