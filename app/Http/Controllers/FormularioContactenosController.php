<?php

namespace App\Http\Controllers;

use App\Models\FormularioContactenos;
use Illuminate\Http\Request;

class FormularioContactenosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FormularioContactenos::all();
        return view('Formularios.contactenos.index', compact('data'));
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
    public function show($id)
    {
        $data = FormularioContactenos::find($id);
        return view('Formularios.contactenos.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormularioContactenos $formularioContactenos)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormularioContactenos $formularioContactenos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormularioContactenos $formularioContactenos)
    {
        //
    }
}
