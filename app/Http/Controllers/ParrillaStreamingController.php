<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use App\Models\ParrillaStreaming;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParrillaStreamingController extends Controller
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
        $data = ParrillaStreaming::all();
        return view('streaming.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = States::all();
        $paises = Paises::all();
        return view('streaming.create', compact('states', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $urlLogo = '';

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = str_replace(['-', '.',' '.'  '], '_', strtolower(Str::slug($request->nombre_tarifa))) . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('/logos', $file, $nombreArchivo);
            $urlLogo = 'https://cms.vuskoo.com/storage/logos/'.$nombreArchivo;
        }

        $tarifa = ParrillaStreaming::create([
            'permanencia' => trim($request->permanencia),
            'nombre_tarifa' => trim($request->nombre_tarifa),
            'detalles_tarifa' => trim($request->detalles_tarifa),
            'categoria' => trim($request->categoria),
            'estado' => $request->estado,
            'recomendaciones' => trim($request->recomendaciones),
            'titulo_relativo_1' => trim($request->titulo_relativo_1),
            'precio_relativo_1' => trim($request->precio_relativo_1),
            'titulo_relativo_2' => trim($request->titulo_relativo_2),
            'precio_relativo_2' => trim($request->precio_relativo_2),
            'titulo_relativo_3' => trim($request->titulo_relativo_3),
            'precio_relativo_3' => trim($request->precio_relativo_3),
            'parrilla_bloque_1' => trim($request->parrilla_bloque_1),
            'precio_parrilla_bloque_1' => trim($request->precio_parrilla_bloque_1),
            'parrilla_bloque_2' => trim($request->parrilla_bloque_2),
            'precio_parrilla_bloque_2' => trim($request->precio_parrilla_bloque_2),
            'parrilla_bloque_3' => trim($request->parrilla_bloque_3),
            'precio_parrilla_bloque_3' => trim($request->precio_parrilla_bloque_3),
            'parrilla_bloque_4' => trim($request->parrilla_bloque_4),
            'precio_parrilla_bloque_4' => trim($request->precio_parrilla_bloque_4),
            'num_meses_promo' => trim($request->num_meses_promo),
            'porcentaje_descuento' => trim($request->porcentaje_descuento),
            'logo' => trim($urlLogo),
            'promocion' => trim($request->promocion),
            'destacada' => trim($request->destacada),
            'fecha_publicacion' => now(),
            'fecha_expiracion' => trim($request->fecha_expiracion),
            'fecha_registro' => now(),
            'moneda' => trim($moneda->moneda),
            'pais' => trim($request->pais),
            'landingLead' => trim($request->landingLead),
            'slug_tarifa' => Str::slug($request->nombre_tarifa),
            'tituloSeo' => $request->tituloSeo,
            'descripcionSeo' => $request->descripcionSeo,
        ]);

        return redirect()->route('streaming.index')->with('info', 'Tarifa creada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $streaming = ParrillaStreaming::find($id);
        $states = States::all();
        $paises = Paises::all();
        return view('streaming.edit', compact('streaming', 'states', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tarifa = ParrillaStreaming::find($id);
        $urlLogo = null;
        $logo_negativo = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = str_replace(['-', '.',' '.'  '], '_', strtolower(Str::slug($request->nombre_tarifa))) . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('logos', $file, $nombreArchivo);
            $urlLogo = 'https://cms.vuskoo.com/storage/logos/'.$nombreArchivo;
        }

        // Crear un array de datos a actualizar
        $data = $request->all();
        if ($urlLogo) {
            $data['logo'] = $urlLogo;
        }

        // Actualizar el modelo

        $moneda = Paises::where('id', $request->pais)->select('moneda')->first();
        $data['parrilla_bloque_1'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_1));
        $data['parrilla_bloque_2'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_2));
        $data['parrilla_bloque_3'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_3));
        $data['parrilla_bloque_4'] = trim(str_replace('  ', ' ', $request->parrilla_bloque_4));
        $data['slug_tarifa'] = Str::slug($request->nombre_tarifa);
        $data['moneda'] = $moneda->moneda;
        $tarifa->update($data);
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function duplicateOffer($id)
    {
        $tarifaBase = ParrillaStreaming::find($id);
        $duplica = $tarifaBase->replicate();
        $duplica->save();
        $tarifa = ParrillaStreaming::find($duplica->id);
        return redirect()->route('streaming.edit', ['streaming' => $duplica->id]);
    }
}
