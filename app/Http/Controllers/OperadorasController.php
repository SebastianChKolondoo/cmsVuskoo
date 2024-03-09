<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\States;
use Illuminate\Http\Request;

class OperadorasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:operadoras.view')->only('index');
        $this->middleware('can:operadoras.view.btn-create')->only('create','store');
        $this->middleware('can:operadoras.view.btn-edit')->only('edit','update');
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
        return view('clientes.operadoras.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permisos = Operadoras::create([
            'nombre' => ($request->name),
            'tipo_conversion' => '',
            'color' => '',
            'color_texto' => '',
            'logo' => ($request->logo),
            'logo_negativo' => ($request->negativo),
            'isotipo' => '',
            'politica_privacidad' => ($request->politica),
            'estado' => ($request->state),
            'fecha_registro' => now(),
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
        return view('clientes.operadoras.edit', compact('operadora', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $operadora)
    {
        $operadoras = Operadoras::find($operadora);
        $operadoras->update($request->all());
        return redirect()->route('operadoras.index')->with('info', 'Operadora editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operadoras $operadoras)
    {
        //
    }
}
