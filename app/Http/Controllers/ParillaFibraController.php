<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\Paises;
use App\Models\ParillaFibra;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaFibraController extends Controller
{
    protected $utilsController;
    protected $quitarTildes;

    public function __construct(UtilsController $utilsController)
    {
        $this->utilsController = $utilsController;
        $this->middleware('can:fibra.view')->only('index');
        $this->middleware('can:fibra.view.btn-create')->only('create', 'store');
        $this->middleware('can:fibra.view.btn-edit')->only('edit', 'update');
    }
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
        $paises = Paises::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        $operadorasList = $operadoras->mapWithKeys(function ($operadora) {
            return [$operadora->id => $operadora->nombre . ' - ' . $operadora->paises->nombre];
        });
        return view('telefonia.fibra.create', compact('states', 'operadorasList', 'operadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $empresa = Operadoras::find($request->operadora);
        $pais = $empresa->pais;
        $moneda = Paises::where('id', $pais)->select('moneda')->first();
        switch ($pais) {
            case 1: //españa
                $landingLead = '/internet-telefonia/comparador-fibra/';
                break;
            case 2: //colombia
                $landingLead = '/internet-movil/comparador-fibra/';
                break;
            case 3: //mexico
                $landingLead = '';
                break;
        }
        $tarifa = ParillaFibra::create([
            'operadora' => $request->operadora,
            'estado' => $request->estado,
            'nombre_tarifa' => $request->nombre_tarifa,
            'landing_link' => $request->landing_link,
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
            'destacada' => $request->destacada,
            'textoAdicional' => $request->textoAdicional,
            'tituloSeo' => $request->tituloSeo,
            'descripcionSeo' => $request->descripcionSeo,
            'orden_parrilla_operadora' => $request->orden_parrilla_operadora,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_expiracion' => $request->fecha_expiracion,
            'fecha_registro' => $request->fecha_registro,
            'moneda' =>  $moneda->moneda,
            'pais' => $pais,
            'landingLead' => $landingLead,
            'duracionContrato' => $request->duracionContrato,
            'slug_tarifa' => $request->slug_tarifa,
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
        $paises = Paises::all();
        $operadoras = Operadoras::all();
        $operadorasList = $operadoras->mapWithKeys(function ($operadora) {
            return [$operadora->id => $operadora->nombre . ' - ' . $operadora->paises->nombre];
        });
        return view('telefonia.fibra.edit', compact('tarifa', 'states', 'operadorasList', 'operadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaFibra)
    {
        $empresa = Operadoras::find($request->operadora);
        $pais = $empresa->pais;
        $moneda = Paises::where('id', $pais)->select('moneda')->first();
        switch ($pais) {
            case 1: //españa
                $landingLead = '/internet-telefonia/comparador-fibra/';
                break;
            case 2: //colombia
                $landingLead = '/internet-movil/comparador-fibra/';
                break;
            case 3: //mexico
                $landingLead = '';
                break;
        }
        $request['landingLead'] = $landingLead;
        $request['pais'] = $pais;
        $request['moneda'] = $moneda->moneda;
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $tarifa = ParillaFibra::find($parillaFibra);
        $tarifa->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
        //return redirect()->route('parrillafibra.index')->with('info', 'Tarifa editada correctamente.');
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaFibra::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaFibra::find($duplica->id);
        return redirect()->route('parrillafibra.edit', ['parrillafibra' => $duplica->id]);
    }
}
