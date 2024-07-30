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
        return view('cupones.cupones.create', compact('tipoCupon', 'states', 'comercios', 'paises', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $empresa = Comercios::find($request->comercio);
        /* $slug = $this->utilsController->quitarTildes(strtolower(str_replace(['  ', 'datos', '--', ' ', '--'], [' ', '', '-', '-', '-'], trim(str_replace('  ', ' ', $request->nombre_tarifa)) . ' ' . $empresa->nombre_slug))); */
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        if ($request['TiempoCupon'] == 2) {
            $fecha_final = '1970-01-01';
            $fecha_inicial = '2099-01-01';
        }
        $tarifa = Cupones::create([
            'comercio' => $request->comercio,
            'codigo' => $request->codigo,
            'titulo' => $request->titulo,
            'descripcion' => trim($request->descripcion),
            'label' => $request->label,
            'CodigoCupon' => trim($request->CodigoCupon),
            'featured' => $request->featured,
            'source' => $request->source,
            'deeplink' => $request->deeplink,
            'affiliate_link' => $request->affiliate_link,
            'cashback_link' => $request->cashback_link,
            'url' => $request->url,
            'image_url' => $request->image_url,
            'tipoCupon' => $request->tipoCupon,
            'merchant_home_page' => $request->merchant_home_page,
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
            'estado' => $request->estado,
            'pais' => $empresa->pais,
            'destacada' => $request->destacada,
            'TiempoCupon' => $request->TiempoCupon
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
        $categorias = Categorias::where('pais', $tarifa->pais)->get();
        $states = States::all();
        $comercios = Comercios::all();
        $tipoCupon = TipoCupon::all();
        return view('cupones.cupones.edit', compact('tipoCupon', 'tarifa', 'states', 'comercios', 'paises', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cupon)
    {
        $empresa = Comercios::find($request->comercio);
        $request['descripcion'] = trim(str_replace('  ', ' ', $request->descripcion));
        $request['pais'] = $empresa->pais;
        if ($request['TiempoCupon'] == 2) {
            $request['fecha_expiracion'] = '2099-01-01';
        }
        if ($request['tipoCupon'] != 1) {
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
