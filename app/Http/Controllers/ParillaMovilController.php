<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\Paises;
use App\Models\ParillaMovil;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class ParillaMovilController extends Controller
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
     * 
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParillaMovil::all();
        return view('telefonia.movil.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $paises = Paises::all();
        $operadoras = Operadoras::where('estado', '1')->get();
        return view('telefonia.movil.create', compact('states', 'operadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Operadoras::find($request->operadora);
        $landingLead = '';
        switch ($request->pais) {
            case 1://españa
                $landingLead = '/internet-telefonia/comparador-movil/';
                break;
            case 2://colombia
                $landingLead = '/planes-celulares-internet-y-tv/comparador-planes-celular/';
                break;
            case 3://mexico
                $landingLead = '/planes-celulares-telefonia-internet-y-tv/comparador-planes-celular/';
                break;
        }
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug)));
        $tarifa = ParillaMovil::create([
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
            'moneda' =>  $moneda->moneda,
            'slug_tarifa' => $slug,
            'pais' => $request->pais,
            'landingLead' => $landingLead
        ]);

        return redirect()->route('parrillamovil.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaMovil $parillaMovil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaMovil)
    {
        $tarifa = ParillaMovil::find($parillaMovil);
        $states = States::all();
        $paises = Paises::all();
        $operadoras = Operadoras::all();
        return view('telefonia.movil.edit', compact('tarifa', 'states', 'operadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaMovil)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        switch ($request->pais) {
            case 1://españa
                $landingLead = '/internet-telefonia/comparador-movil/';
                break;
            case 2://colombia
                $landingLead = '/planes-celular-internet/comparador-plan-celular/';
                break;
            case 3://mexico
                $landingLead = '/planes-celulares-telefonia-internet-y-tv/comparador-planes-celular/';
                break;
        }
        $empresa = Operadoras::find($request->operadora);
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug)));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $request['moneda'] = $moneda->moneda;
        $request['landingLead'] = $landingLead;
        $tarifa = ParillaMovil::find($parillaMovil);
        $tarifa->update($request->all());
        return redirect()->route('parrillamovil.index')->with('info', 'Tarifa editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaMovil::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaMovil::find($duplica->id);
        return redirect()->route('parrillamovil.edit', ['parrillamovil' => $duplica->id]);
    }
}
