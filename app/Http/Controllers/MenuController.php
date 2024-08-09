<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Paises;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Menu::all();
        return view('menu.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = Paises::all();
        return view('menu.create', compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nombreVariable = 'nombresubmenu_';
        $datosRequest = $request->all();
        $cantidad = count(array_filter($datosRequest, function ($key) use ($nombreVariable) {
            return strpos($key, $nombreVariable) === 0;
        }, ARRAY_FILTER_USE_KEY));

        $id = Menu::create([
            'titulo' => $request->titulo,
            'urlTitulo' => $request->urlTitulo,
            'pais' => $request->pais
        ]);

        if ($cantidad > 0) {

            for ($i = 0; $i < $cantidad; $i++) {
                MenuItem::create([
                    'idMenu' => $id->id,
                    'nombre' => $request->input('nombresubmenu_' . $i),
                    'url' => $request->input('urlsubmenu_' . $i),
                    'orden' => $request->input('ordensubmenu_' . $i),

                ]);
            }
        }

        return redirect()->route('paginawebmenu.index')->with('info', 'Menú creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $items = MenuItem::where('idMenu',$id)->get();
        $paises = Paises::all();
        $idMenu = $id;
        return view('menu.edit', compact('menu','items','paises','idMenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Menu::find($id);
        $data->update($request->all());
        return back()->with('info', 'Menú editado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $item = Menu::findOrFail($id);
        $item->delete();

        return redirect()->route('paginawebmenu.index')->with('info', 'Menú eliminado correctamente.');
    }
}
