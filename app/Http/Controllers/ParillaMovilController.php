<?php

namespace App\Http\Controllers;

use App\Models\ParillaMovil;
use App\Models\ParrillaMovil;
use Illuminate\Http\Request;

class ParillaMovilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifas = ParrillaMovil::all();
        return view('telefonia.movil.index', compact('tarifas'));
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
    public function show(ParillaMovil $parillaMovil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParillaMovil $parillaMovil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParillaMovil $parillaMovil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParillaMovil $parillaMovil)
    {
        //
    }
}
