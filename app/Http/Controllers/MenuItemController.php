<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(MenuItem $menuItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = MenuItem::find($id);
        $data->update($request->all());
        return back()->with('info', 'Sub-menú editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return back()->with('info', 'Sub-menú eliminado correctamente.');
    }

    public function addStoreItemEdit(Request $request, $id)
    {
        $nombreVariable = 'nombresubmenu_';
        $datosRequest = $request->all();

        $cantidad = count(array_filter($datosRequest, function ($key) use ($nombreVariable) {
            return strpos($key, $nombreVariable) === 0;
        }, ARRAY_FILTER_USE_KEY));
        
        if ($cantidad > 0) {

            for ($i = 0; $i < $cantidad; $i++) {
                MenuItem::create([
                    'idMenu' => $id,
                    'nombre' => $request->input('nombresubmenu_' . $i),
                    'url' => $request->input('urlsubmenu_' . $i),
                    'orden' => $request->input('ordensubmenu_' . $i),

                ]);
            }
        }
        return back()->with('info', 'Sub-menú creado correctamente.');
    }
}
