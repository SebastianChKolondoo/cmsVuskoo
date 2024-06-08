<?php

namespace App\Http\Controllers;

use App\Models\TipoCupon;
use Illuminate\Http\Request;

class TipoCuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoCupones = TipoCupon::all();
        return view('tipoCupones.index', compact('tipoCupones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipoCupones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TipoCupon::create([
            'nombre' => $request->nombre,
        ]);
        return redirect()->route('tipoCupones.index')->with('info', 'Tipo de cupón creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCupon $tipoCupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipoCupon = TipoCupon::find($id);
        return view('tipoCupones.edit', compact('tipoCupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipoCupon = TipoCupon::find($id);
        $tipoCupon->update($request->all());
        return redirect()->route('tipoCupones.index')->with('info', 'Tipo de cupon editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCupon $tipoCupon)
    {
        //
    }
}
