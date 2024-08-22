<?php

namespace App\Http\Controllers;

use App\Models\FormularioNewsletter;
use Illuminate\Http\Request;

class FormularioNewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FormularioNewsletter::orderBy('id', 'desc')->get();
        return view('Formularios.newsletter.index', compact('data'));
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
        $data = FormularioNewsletter::find($id);
        return view('Formularios.contactenos.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormularioNewsletter $formularioNewsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormularioNewsletter $formularioNewsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormularioNewsletter $formularioNewsletter)
    {
        //
    }
}
