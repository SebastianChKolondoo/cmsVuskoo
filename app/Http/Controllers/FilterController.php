<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    protected $tabla_luz = 'WEB_3_TARIFAS_ENERGIA_LUZ';
    protected $tabla_gas = 'WEB_3_TARIFAS_ENERGIA_GAS';
    protected $tabla_luz_gas = 'WEB_3_TARIFAS_ENERGIA_LUZ_GAS';
    protected $tabla_movil = 'WEB_3_TARIFAS_TELCO_MOVIL';
    protected $tabla_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA';
    protected $tabla_tv = 'WEB_3_TARIFAS_TELCO_TV';
    protected $tabla_movil_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL';
    protected $tabla_movil_fibra_tv = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL_TV';
    protected $tabla_vehiculo = 'WEB_3_VEHICULOS';
    protected $tabla_vehiculos = '1_vehiculos';

    /* funciones para llamar las bases para los filtros de precio */
    public function getValuesFilterMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil)
            ->selectRaw('ROUND(MAX(GB)+5) as max_gb, ROUND(MAX(precio)+5) as max_precio, ROUND(MIN(GB)-5) as min_gb, ROUND(MIN(precio)-5) as min_precio, moneda')
            ->where('pais',$idioma->id)
            ->get();
    }

    public function getValuesFilterFibraMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil_fibra)
            ->selectRaw('ROUND(MAX(GB)+5) as max_gb, ROUND(MAX(precio)+5) as max_precio, ROUND(MIN(GB)-5) as min_gb, ROUND(MIN(precio)-5) as min_precio, moneda')
            ->where('pais',$idioma->id)
            ->get();
    }

    public function getValuesFilterFibraMovilTvList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil_fibra_tv)
            ->selectRaw('ROUND(MAX(GB)+5) as max_gb, ROUND(MAX(precio)+5) as max_precio, ROUND(MIN(GB)-5) as min_gb, ROUND(MIN(precio)-5) as min_precio, moneda')
            ->where('pais',$idioma->id)
            ->get();
    }

    public function getValuesFilterFibraList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_fibra)
            ->selectRaw('ROUND(MAX(precio)+5) as max_precio, ROUND(MIN(precio)-5) as min_precio, moneda')
            ->where('pais',$idioma->id)
            ->get();
    }
    
    public function getValuesFilterPlanCelularList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil)
            ->selectRaw('ROUND(MAX(precio)+5) as max_precio, ROUND(MIN(precio)-5) as min_precio, moneda')
            ->where('pais', '=', $idioma->id)
            ->get();
    }
    
    public function getValuesFilterVehiculosList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_vehiculo)
            ->selectRaw('ROUND(MAX(price)+1000) as max_precio, 
            ROUND(MIN(price)-1000) as min_precio,
            ROUND(MAX(year)) as max_year, 
            ROUND(MIN(year)) as min_year,
            ROUND(MAX(cylinderCapacity)) as max_cylinder, 
            ROUND(MIN(cylinderCapacity)) as min_cylinder,
            ROUND(MAX(hp)) as max_hp, 
            ROUND(MIN(hp)) as min_hp')
            ->where('pais',$idioma->id)
            ->get();
    }

    public function getValuesFilterVehiculosChassisList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_vehiculo)
            ->selectRaw('distinct chassis')
            ->where('pais',$idioma->id)
            ->get();
    }
    /* fin funciones para filtros */
}
