<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Paises;
use App\Models\TraduccionCategorias;
use Illuminate\Http\Request;

class TraduccionCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Categorias::all();
        return view('traduccionCategorias.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Paises::all();
        return view('traduccionCategorias.create', compact('data'));
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
    public function show(TraduccionCategorias $traduccionCategorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categorias::find($id);
        $data = Paises::all();
        return view('traduccionCategorias.edit', compact('data','categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TraduccionCategorias $traduccionCategorias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraduccionCategorias $traduccionCategorias)
    {
        //
    }
}
