<?php

namespace App\Http\Controllers;

use App\Models\Operadoras;
use App\Models\States;
use Illuminate\Http\Request;

class OperadorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operadoras = Operadoras::all();
        return view('operadoras.index', compact('operadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('operadoras.edit', compact('operadora', 'estados'));
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
