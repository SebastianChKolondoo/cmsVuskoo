<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use App\Models\Paises;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bancos = Banca::all();
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.banca.index', compact('bancos', 'estados','paises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.banca.create', compact('estados','paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $urlLogo = '';

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) .'_'.strtolower($request->pais). '.' . $extension;
            $path = Storage::disk('public')->putFileAs('/logos', $file, $nombreArchivo);
            $urlLogo = Storage::disk('public')->url($path);
        }

        Banca::create([
            'nombre' => $request->nombre,
            'pais' => $request->pais,
            'logo' => trim($urlLogo),
            'estado' => $request->estado
        ]);
        return redirect()->route('bancos.index')->with('info', 'Banco creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banca $banca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banco = Banca::find($id);
        $estados = States::all();
        $paises = Paises::all();
        return view('clientes.banca.edit', compact('banco', 'estados','paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tarifa = Banca::find($id);
        $urlLogo = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) .'_'.strtolower($request->pais). '.' . $extension;
            $path = Storage::disk('public')->putFileAs('/logos', $file, $nombreArchivo);
            $urlLogo = Storage::disk('public')->url($path);
        }

        $data = $request->all();
        if ($urlLogo) {
            $data['logo'] = $urlLogo;
        }

        $tarifa->update($data);

        return redirect()->route('bancos.index')->with('info', 'comercio editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banca $banca)
    {
        //
    }
}
