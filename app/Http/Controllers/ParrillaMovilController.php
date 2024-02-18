<?php

namespace App\Http\Controllers;

use App\Models\ParrillaMovil;
use Illuminate\Http\Request;

class ParrillaMovilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parrilla = ParrillaMovil::all();
        return view('parrilas.movil.index', compact('parrilla'));
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
    public function show(ParrillaMovil $parrillaMovil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParrillaMovil $parrillaMovil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParrillaMovil $parrillaMovil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParrillaMovil $parrillaMovil)
    {
        //
    }
}
