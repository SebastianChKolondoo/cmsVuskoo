<?php

namespace App\Http\Controllers;

use App\Models\FormularioLeads;
use Illuminate\Http\Request;

class FormularioLeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FormularioLeads::all();
        return view('Formularios.leads.index', compact('data'));
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
        $data = FormularioLeads::find($id);
        return view('Formularios.leads.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormularioLeads $formularioLeads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormularioLeads $formularioLeads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormularioLeads $formularioLeads)
    {
        //
    }
}
