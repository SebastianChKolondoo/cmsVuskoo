<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use App\Models\Proveedores;
use App\Models\SegurosSalud;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SegurosSaludController extends Controller
{
    public function index()
    {
        $data = SegurosSalud::all();
        return view('seguros.salud.index', compact('data'));
    }

    public function create()
    {
        $estados = States::all();
        $paises = Paises::all();
        $proveedores = Proveedores::all();
        return view('seguros.salud.create', compact('proveedores', 'estados', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        SegurosSalud::create([
            'proveedor' => $request->proveedor,
            'selector_1' => $request->selector_1,
            'precio_1' => $request->precio_1,
            'divisa_1' => $request->divisa_1,
            'selector_2' => $request->selector_2,
            'precio_2' => $request->precio_2,
            'divisa_2' => $request->divisa_2,
            'parrilla_1' => $request->parrilla_1,
            'parrilla_2' => $request->parrilla_2,
            'parrilla_3' => $request->parrilla_3,
            'parrilla_4' => $request->parrilla_4,
            'url_redirct' => $request->url_redirct,
            'destacada' => $request->destacada,
            'estado' => $request->estado,
            'pais' => $request->pais,
            'verificacion_video' => $request->verificacion_video,
            'compatible_mascotas' => $request->compatible_mascotas,
            'boton_panico' => $request->boton_panico,
            'fotodetector' => $request->fotodetector,
            'detector_infrarrojo' => $request->detector_infrarrojo,
            'detector_magnetico' => $request->detector_magnetico,
            'llaves_tags' => $request->llaves_tags,
            'extras' => $request->extras,
            'copago' => $request->copago,
            'slug_tarifa' => Str::slug($request->slug_tarifa),
            

        ]);

        return redirect()->route('segurossalud.index')->with('info', 'Oferta creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SegurosSalud $segurosSalud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $oferta = SegurosSalud::find($id);
        $estados = States::all();
        $proveedores = Proveedores::all();
        $paises = Paises::all();
        return view('seguros.salud.edit', compact('oferta', 'estados', 'paises', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $alarma)
    {
        $request['slug_tarifa'] = Str::slug($request->slug_tarifa);
        $alarma = SegurosSalud::find($alarma);
        $alarma->update($request->all());
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SegurosSalud $segurosSalud)
    {
        //
    }
}
