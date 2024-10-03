<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\Paises;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComercializadorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comercializadoras = Comercializadoras::all();
        return view('clientes.comercializadoras.index', compact('comercializadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.comercializadoras.create', compact('estados', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $urlLogo = '';
        $logo_negativo = '';
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->name) . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('/logos', $file, $nombreArchivo);
            $urlLogo = Storage::disk('public')->url($path);
        }
        if ($request->hasFile('logo_negativo')) {
            $file = $request->file('logo_negativo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->name) . '_negativo.' . $extension;
            $path = Storage::disk('public')->putFileAs('/logos', $file, $nombreArchivo);
            $logo_negativo = Storage::disk('public')->url($path);
        }

        Comercializadoras::create([
            'nombre' => $request->nombre,
            'nombre_slug' => $request->nombre_slug,
            'tipo_conversion' => $request->tipo_conversion,
            'logo' => $urlLogo,
            'logo_negativo' => $logo_negativo,
            'politica_privacidad' => $request->politica_privacidad,
            'estado' => $request->estado,
            'pais' => $request->pais

        ]);

        return redirect()->route('comercializadoras.index')->with('info', 'Comercializadora creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comercializadoras $comercializadoras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comercializadora = Comercializadoras::find($id);
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.comercializadoras.edit', compact('comercializadora', 'estados', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $comercializadora)
    {
        $comercializadoras = Comercializadoras::find($comercializadora);
        
        $urlLogo = null;
        $logo_negativo = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('logos', $file, $nombreArchivo);
            $urlLogo = 'https://cms.vuskoo.com/storage/logos/'.$nombreArchivo;
        }

        if ($request->hasFile('logo_negativo')) {
            $file = $request->file('logo_negativo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) . '_negativo.' . $extension;
            $path = Storage::disk('public')->putFileAs('logos', $file, $nombreArchivo);
            $logo_negativo = 'https://cms.vuskoo.com/storage/logos/'.$nombreArchivo;
        }

        // Crear un array de datos a actualizar
        $data = $request->all();
        if ($urlLogo) {
            $data['logo'] = $urlLogo;
        }
        if ($logo_negativo) {
            $data['logo_negativo'] = $logo_negativo;
        }

        // Actualizar el modelo
        $comercializadoras->update($data);
        return back()->with('info', 'Información actualizada correctamente.');
        //return redirect()->route('comercializadoras.index')->with('info', 'Comercializadora editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comercializadoras $comercializadoras)
    {
        //
    }
}
