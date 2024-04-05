<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\Paises;
use App\Models\ParillaLuz;
use App\Models\States;
use Illuminate\Http\Request;

class ParillaLuzController extends Controller
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
        $tarifas = ParillaLuz::all();
        return view('energia.luz.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $paises = Paises::all();
        $comercializadoras = Comercializadoras::where('estado', '1')->get();
        return view('energia.luz.create', compact('states', 'comercializadoras', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora);
        //$slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug));
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug)));
        $tarifa = ParillaLuz::create([
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
            'promocion' => $request->promocion,
            'num_meses_promo' => $request->num_meses_promo,
            'texto_alternativo_promo' => $request->texto_alternativo_promo,
            'coste_de_gestion' => $request->coste_de_gestion,
            'destacada' => $request->destacada,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_expiracion' => $request->fecha_expiracion,
            'fecha_registro' => $request->fecha_registro,
            'moneda' =>  $moneda->moneda,
            'slug_tarifa' => $slug,
            'pais' => $request->pais
        ]);

        return redirect()->route('parrillaluz.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParillaLuz $parillaLuz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parillaLuz)
    {
        $tarifa = ParillaLuz::find($parillaLuz);
        $paises = Paises::all();
        $states = States::all();
        $comercializadoras = Comercializadoras::all();
        return view('energia.luz.edit', compact('tarifa', 'states', 'comercializadoras', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parillaLuz)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercializadoras::find($request->comercializadora);
        //$slug = strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug));
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->parrilla_bloque_1)) . ' ' . trim(str_replace('  ', ' ', $request->parrilla_bloque_2)) . ' ' . $empresa->nombre_slug)));
        $request['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $request['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $request['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $request['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $request['slug_tarifa'] = $slug;
        $request['moneda'] = $moneda->moneda;
        $tarifa = ParillaLuz::find($parillaLuz);
        $tarifa->update($request->all());
        return redirect()->route('parrillaluz.index')->with('info', 'Tarifa editada correctamente.');
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = ParillaLuz::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParillaLuz::find($duplica->id);
        return redirect()->route('parrillaluz.edit', ['parrillaluz' => $duplica->id]);
    }
}
