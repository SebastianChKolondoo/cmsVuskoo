<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comercios;
use App\Models\Cupones;
use App\Models\Paises;
use App\Models\States;
use App\Models\TipoCupon;
use Illuminate\Http\Request;

class CuponesController extends Controller
{
    protected $utilsController;
    protected $quitarTildes;

    public function __construct(UtilsController $utilsController)
    {
        $this->utilsController = $utilsController;
    }

    public function index()
    {
        $tarifas = Cupones::all();
        return view('cupones.cupones.index', compact('tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $categorias = Categorias::all();
        $comercios = Comercios::where('estado', '1')->get();
        $paises = Paises::all();
        $tipoCupon = TipoCupon::all();
        return view('cupones.cupones.create', compact('tipoCupon','states', 'comercios', 'paises','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercios::find($request->comercio);
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->nombre_tarifa)) . ' ' . $empresa->nombre_slug)));
        $fechaExpiracion = $request->fecha_expiracion;
        if($request['TiempoCupon'] == 2){
            $fechaExpiracion = '2099-01-01';
        }
        $tarifa = Cupones::create([
            'comercio' => $request->comercio,
            'estado' => $request->estado,
            'nombre_tarifa' => $request->nombre_tarifa,
            'descripcion' => trim($request->descripcion),
            'categoria' => $request->categoria,
            'destacada' => $request->destacada,
            'fecha_expiracion' => $fechaExpiracion,
            'moneda' =>  $moneda->moneda,
            'slug_tarifa' => $slug,
            'pais' => $request->pais,
            'codigo' => $request->codigo,
            'descuento' => $request->descuento,
            'landing_link' => $request->landing_link,
            'tipoCupon' => $request->tipoCupon,
            'TiempoCupon' => $request->TiempoCupon,
            'CodigoCupon' => $request->CodigoCupon,
            /* 'pagina_final' => $request->pagina_final */
        ]);

        return redirect()->route('cupones.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cupones $cupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($cupon)
    {
        $tarifa = Cupones::find($cupon);
        $paises = Paises::all();
        $categorias = Categorias::where('pais',$tarifa->pais)->get();
        $states = States::all();
        $comercios = Comercios::all();
        $tipoCupon = TipoCupon::all();
        return view('cupones.cupones.edit', compact('tipoCupon','tarifa', 'states', 'comercios', 'paises','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cupon)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercios::find($request->comercio);
        $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->nombre_tarifa)) . ' ' . $empresa->nombre_slug)));
        $request['descripcion'] = trim(str_replace('  ', ' ', $request->descripcion));
        $request['slug_tarifa'] = $slug;
        $request['moneda'] = $moneda->moneda;
        if($request['TiempoCupon'] == 2){
            $request['fecha_expiracion'] = '2099-01-01';
        }
        if($request['tipoCupon'] != 3){
            $request['CodigoCupon'] = NULL;
        }
        $tarifa = Cupones::find($cupon);
        $request->all();
        $tarifa->update($request->all());
        return redirect()->route('cupones.index')->with('info', 'Cupón editada correctamente.');
    }

    public function duplicateOffer($id)
    {
        $tarifaBase = Cupones::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = Cupones::find($duplica->id);
        return redirect()->route('cupones.edit', ['cupone' => $tarifa->id]);
    }
}
