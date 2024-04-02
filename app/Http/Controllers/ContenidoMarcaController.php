<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\ContenidoMarca;
use App\Models\Operadoras;
use Illuminate\Http\Request;

class ContenidoMarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operadoras = Operadoras::all();
        $comercializadoras = Comercializadoras::all();
        return view('ContenidoMarca.index', compact('operadoras', 'comercializadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function createContent($id)
    {
        return view('ContenidoMarca.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(ContenidoMarca $contenidoMarca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContenidoMarca $contenidoMarca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContenidoMarca $contenidoMarca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContenidoMarca $contenidoMarca)
    {
        //
    }
}
