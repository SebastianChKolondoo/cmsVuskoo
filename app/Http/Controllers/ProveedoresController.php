<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use App\Models\Proveedores;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedores = Proveedores::all();
        return view('clientes.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.proveedores.create', compact('estados', 'paises'));
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

        Proveedores::create([
            'nombre' => $request->nombre,
            'nombre_slug' => $request->nombre_slug,
            'tipo_conversion' => $request->tipo_conversion,
            'logo' => $urlLogo,
            'logo_negativo' => $logo_negativo,
            'politica_privacidad' => $request->politica_privacidad,
            'estado' => $request->estado,
            'pais' => $request->pais,
            'telefono' => $request->telefono,

        ]);

        return redirect()->route('proveedores.index')->with('info', 'Proveedor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedores $proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedor = Proveedores::find($id);
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.proveedores.edit', compact('proveedor', 'estados', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $proveedor)
    {
        $proveedores = Proveedores::find($proveedor);

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
        $proveedores->update($data);
        return back()->with('info', 'Información actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedores $proveedores)
    {
        //
    }
}
