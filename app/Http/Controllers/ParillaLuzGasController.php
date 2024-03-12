<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\Paises;
use App\Models\ParillaLuzGas;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaLuzGasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaLuzGas::all();
        return view('energia.luzgas.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $paises = Paises::all();
        $comercializadoras = Comercializadoras::where('estado', '1')->get();
        return view('energia.luzgas.create', compact('states', 'comercializadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('codigo', $request->pais)->pluck('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $tarifa = ParillaLuzGas::create([
            'comercializadora' => $request->comercializadora,
            'estado' => $request->estado,
            'nombre_tarifa' => $request->nombre_tarifa,
            'landing_link' => $request->landing_link,
            'parrilla_bloque_1' => trim(str_replace('  ', ' ', $request->parrilla_bloque_1)),
            'parrilla_bloque_2' => trim(str_replace('  ', ' ', $request->parrilla_bloque_2)),
            'parrilla_bloque_3' => trim(str_replace('  ', ' ', $request->parrilla_bloque_3)),
            'parrilla_bloque_4' => trim(str_replace('  ', ' ', $request->parrilla_bloque_4)),
            'landing_dato_adicional' => $request->landing_dato_adicional,
            'meses_permanencia' => $request->meses_permanencia,
            'luz_discriminacion_horaria' => $request->luz_discriminacion_horaria,
            'precio' => $request->precio,
            'precio_final' => $request->precio_final,
            'luz_precio_potencia_punta' => $request->luz_precio_potencia_punta,
            'luz_precio_potencia_valle' => $request->luz_precio_potencia_valle,
            'luz_precio_energia_punta' => $request->luz_precio_energia_punta,
            'luz_precio_energia_llano' => $request->luz_precio_energia_llano,
            'luz_precio_energia_valle' => $request->luz_precio_energia_valle,
            'luz_precio_energia_24h' => $request->luz_precio_energia_24h,
            'energia_verde' => $request->energia_verde,
            'imagen_promo' => $request->imagen_promo,
            'promocion' => $request->promocion,
            'num_meses_promo' => $request->num_meses_promo,
            'texto_alternativo_promo' => $request->texto_alternativo_promo,
            'coste_mantenimiento' => $request->coste_mantenimiento,
            'coste_de_gestion' => $request->coste_de_gestion,
            'gas_tipo_precio' => $request->gas_tipo_precio,
            'gas_precio_termino_fijo' => $request->gas_precio_termino_fijo,
            'gas_precio_energia' => $request->gas_precio_energia,
            'destacada' => $request->destacada,
            'orden_parrilla_comercializadora' => $request->orden_parrilla_comercializadora,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_expiracion' => $request->fecha_expiracion,
            'fecha_registro' => $request->fecha_registro,
            'moneda' => $moneda,
            'slug_tarifa' => $slug,
            'pais' => $request->pais
        ]);

        return redirect()->route('parrillaluzgas.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaLuzGas $parillaLuzGas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaLuzGas)
    {
        $tarifa = ParillaLuzGas::find($parillaLuzGas);
        $states = States::all();
        $paises = Paises::all();
        $comercializadoras = Comercializadoras::all();
        return view('energia.luzgas.edit', compact('tarifa', 'states', 'comercializadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaLuzGas)
    {
        $moneda = Paises::where('codigo', $request->pais)->pluck('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora)->pluck('nombre')->first();
        $slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $request['moneda'] = $moneda;
        $tarifa = ParillaLuzGas::find($parillaLuzGas);
        $tarifa->update($request->all());
        return redirect()->route('parrillaluzgas.index')->with('info', 'Tarifa editada correctamente.');
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaLuzGas::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaLuzGas::find($duplica->id);
        return redirect()->route('parrillaluzgas.edit', ['parrillaluzga' => $duplica->id]);
    }
}
