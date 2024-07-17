<?php

namespace App\Http\Controllers;

use App\Models\PaginaWebFooter;
use App\Models\Paises;
use Illuminate\Http\Request;

class PaginaWebFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paises = Paises::all();
        return view('pagina.web.index', compact('paises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pagina.web.create');
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
    public function show(PaginaWebFooter $paginaWebFooter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $validacion = PaginaWebFooter::where('pais',$id)->count();
        if($validacion == 0){
            PaginaWebFooter::create([
                'pais' => $id
            ]);
        }
        $data = PaginaWebFooter::where('pais',$id)->first();
        $pais = $id;
        return view('pagina.web.edit', compact('data','pais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request['pais'] = $request->pais;
        $tarifa = PaginaWebFooter::find($id);
        $tarifa->update($request->all());
        return redirect()->route('paginaweb.index')->with('info', 'Footer editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaginaWebFooter $paginaWebFooter)
    {
        //
    }
}
