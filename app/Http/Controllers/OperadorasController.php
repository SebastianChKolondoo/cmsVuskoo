<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\Paises;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperadorasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:operadoras.view')->only('index');
        $this->middleware('can:operadoras.view.btn-create')->only('create', 'store');
        $this->middleware('can:operadoras.view.btn-edit')->only('edit', 'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operadoras = Operadoras::all();
        return view('clientes.operadoras.index', compact('operadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados =  States::all();
        $paises = Paises::all();
        return view('clientes.operadoras.create', compact('estados', 'paises'));
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


        Operadoras::create([
            'nombre' => $request->nombre,
            'nombre_slug' => $request->nombre_slug,
            'tipo_conversion' => $request->tipo_conversion,
            'logo' => $urlLogo,
            'logo_negativo' => $logo_negativo,
            'politica_privacidad' => $request->politica_privacidad,
            'estado' => $request->estado,
            'pais' => $request->pais

        ]);

        return redirect()->route('operadoras.index')->with('info', 'Operadora creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Operadoras $operadoras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operadora = Operadoras::find($id);
        $estados = States::all();
        $paises = Paises::all();

        return view('clientes.operadoras.edit', compact('operadora', 'estados', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $operadora)
    {
        $operadora = Operadoras::find($operadora);
        $urlLogo = '';
        $logo_negativo = '';

        $urlLogo = null;
        $logo_negativo = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('logos', $file, $nombreArchivo);
            $urlLogo = Storage::disk('public')->url($path);
        }

        if ($request->hasFile('logo_negativo')) {
            $file = $request->file('logo_negativo');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = strtolower($request->nombre) . '_negativo.' . $extension;
            $path = Storage::disk('public')->putFileAs('logos', $file, $nombreArchivo);
            $logo_negativo = Storage::disk('public')->url($path);
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
        $operadora->update($data);

        return redirect()->route('operadoras.index')->with('info', 'Operadora editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operadoras $operadoras)
    {
        //
    }
}
