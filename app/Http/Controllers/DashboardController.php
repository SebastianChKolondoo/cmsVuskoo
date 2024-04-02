<?php

namespace App\Http\Controllers;

use App\Models\Comercializadoras;
use App\Models\Operadoras;
use App\Models\ParillaFibra;
use App\Models\ParillaFibraMovil;
use App\Models\ParillaFibraMovilTv;
use App\Models\ParillaGas;
use App\Models\ParillaLuz;
use App\Models\ParillaLuzGas;
use App\Models\ParillaMovil;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function contadorServicio($servicio = 1)
    {
        $operadoras = Operadoras::count();
        $operadorasOn = Operadoras::where('estado', 1)->count();
        
        $comercializadoras = Comercializadoras::count();
        $comercializadorasOn = Comercializadoras::where('estado', 1)->count();

        $movil = ParillaMovil::count();
        $movilOn = ParillaMovil::where('estado', 1)->count();

        $fibra = ParillaFibra::count();
        $fibraOn = ParillaFibra::where('estado', 1)->count();

        $fibraMovil = ParillaFibraMovil::count();
        $fibraMovilOn = ParillaFibraMovil::where('estado', 1)->count();

        $fibraMovilTv = ParillaFibraMovilTv::count();
        $fibraMovilTvOn = ParillaFibraMovilTv::where('estado', 1)->count();

        $luz = ParillaLuz::count();
        $luzOn = ParillaLuz::where('estado', 1)->count();

        $gas = ParillaGas::count();
        $gasOn = ParillaGas::where('estado', 1)->count();

        $luzgas = ParillaLuzGas::count();
        $luzgasOn = ParillaLuzGas::where('estado', 1)->count();

        return view('home', compact(
            'operadoras',
            'operadorasOn',
            'comercializadoras',
            'comercializadorasOn',
            'movil',
            'movilOn',
            'fibra',
            'fibraOn',
            'fibraMovil',
            'fibraMovilOn',
            'fibraMovilTv',
            'fibraMovilTvOn',
            'luz',
            'luzOn',
            'gas',
            'gasOn',
            'luzgas',
            'luzgasOn',
        ));
    }
}
