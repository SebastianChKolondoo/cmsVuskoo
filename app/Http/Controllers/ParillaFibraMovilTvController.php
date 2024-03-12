<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\Paises;
use App\Models\ParillaFibraMovilTv;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaFibraMovilTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaFibraMovilTv::all();
        return view('telefonia.fibramoviltv.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = Paises::all();
        $states = States::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.fibramoviltv.create', compact('states', 'operadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('codigo', $request->pais)->pluck('moneda')->first();
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $tarifa = ParillaFibraMovilTv::create([
            'operadora' => $request->operadora,
            'estado' => $request->estado,
            'nombre_tarifa' => $request->nombre_tarifa,
            'landing_link' => $request->landing_link,
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
            'moneda' => $moneda,
            'slug_tarifa' => $slug,
            'pais' => $request->pais
        ]);

        return redirect()->route('parrillafibramoviltv.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaFibraMovilTv $parillaMoviltv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaMoviltv)
    {
        $tarifa = ParillaFibraMovilTv::find($parillaMoviltv);
        $states = States::all();
        $paises = Paises::all();
        $operadoras = Operadoras::all();
        return view('telefonia.fibramoviltv.edit', compact('tarifa', 'states', 'operadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaMoviltv)
    {
        $moneda = Paises::where('codigo', $request->pais)->pluck('moneda')->first();
        $empresa = Operadoras::find($request->operadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $request['moneda'] = $moneda;
        $tarifa = ParillaFibraMovilTv::find($parillaMoviltv);
        $tarifa->update($request->all());
        return redirect()->route('parrillafibramoviltv.index')->with('info', 'Tarifa editada correctamente.');
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaFibraMovilTv::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaFibraMovilTv::find($duplica->id);
        return redirect()->route('parrillafibramoviltv.edit', ['parrillafibramoviltv' => $duplica->id]);
    }
}
