<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\Paises;
use App\Models\ParillaGas;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParillaGasController extends Controller
{
    protected $utilsController;
    protected $quitarTildes;

    public function __construct(UtilsController $utilsController)
    {
        $this->utilsController = $utilsController;
        //$this->middleware('can:fibra.view')->only('index');
        //$this->middleware('can:fibra.view.btn-create')->only('create', 'store');
        //$this->middleware('can:fibra.view.btn-edit')->only('edit', 'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaGas::all();
        return view('energia.gas.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $paises = Paises::all();
        $comercializadoras = Comercializadoras::where('estado', '1')->get();
        return view('energia.gas.create', compact('states', 'comercializadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora);
        $tarifa = ParillaGas::create([
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
            'textoAdicional' => $request->textoAdicional,
            'promocion' => $request->promocion,
            'num_meses_promo' => $request->num_meses_promo,
            'texto_alternativo_promo' => $request->texto_alternativo_promo,
            'coste_mantenimiento' => $request->coste_mantenimiento,
            'coste_de_gestion' => $request->coste_de_gestion,
            'gas_tipo_precio' => $request->gas_tipo_precio,
            'gas_precio_termino_fijo' => $request->gas_precio_termino_fijo,
            'gas_precio_termino_variable' => $request->gas_precio_termino_variable,
            'gas_precio_energia' => $request->gas_precio_energia,
            'destacada' => $request->destacada,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_expiracion' => $request->fecha_expiracion,
            'fecha_registro' => $request->fecha_registro,
            'moneda' =>  $moneda->moneda,
            'slug_tarifa' => Str::slug($request->slug_tarifa),
            'pais' => $request->pais,
            'textoAdicional' => $request->textoAdicional,
            'tituloSeo' => $request->tituloSeo,
            'descripcionSeo' => $request->descripcionSeo,
            'informacionLegal' => $request->informacionLegal,
            /* 'tarifa_empresarial' => $request->tarifa_empresarial */
        ]);

        return redirect()->route('parrillagas.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaGas $parillaGas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaGas)
    {
        $tarifa = ParillaGas::find($parillaGas);
        $states = States::all();
        $paises = Paises::all();
        $comercializadoras = Comercializadoras::all();
        return view('energia.gas.edit', compact('tarifa', 'states', 'comercializadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaGas)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora);
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['moneda'] = $moneda->moneda;
        $request['slug_tarifa'] = Str::slug($request->slug_tarifa);
        $tarifa = ParillaGas::find($parillaGas);
        $tarifa->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaGas::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaGas::find($duplica->id);
        return redirect()->route('parrillagas.edit', ['parrillaga' => $duplica->id]);
    }
}
