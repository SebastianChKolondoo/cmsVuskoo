<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;

class ApiController extends Controller
{
    protected $tabla_luz;
    protected $tabla_gas;
    protected $tabla_luz_gas;
    protected $tabla_movil;
    protected $tabla_fibra;
    protected $tabla_tv;
    protected $tabla_movil_fibra;
    protected $tabla_movil_fibra_tv;

    public function __construct()
    {
        $this->tabla_luz = 'WEB_3_TARIFAS_ENERGIA_LUZ';
        $this->tabla_gas = 'WEB_3_TARIFAS_ENERGIA_GAS';
        $this->tabla_luz_gas = 'WEB_3_TARIFAS_ENERGIA_LUZ_GAS';

        $this->tabla_movil = 'WEB_3_TARIFAS_TELCO_MOVIL';
        $this->tabla_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA';
        $this->tabla_tv = 'WEB_3_TARIFAS_TELCO_TV';
        $this->tabla_movil_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL';
        $this->tabla_movil_fibra_tv = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL_TV';
    }

    public function index()
    {
        return view('swagger');
    }

    public function getMenuList(){
        // Crear el array de objetos
        return $data = [
            [
                "title" => "Internet y Telefonía",
                "titleUrl" => "/internet-telefonia",
                "children" => [
                    [
                        "name" => "Fibra",
                        "url" => "/internet-telefonia/comparador-fibra"
                    ],
                    [
                        "name" => "Móvil",
                        "url" => "/internet-telefonia/comparador-movil"
                    ],
                    [
                        "name" => "Fibra y móvil",
                        "url" => "/internet-telefonia/comparador-tarifas-fibra-y-movil"
                    ],
                    [
                        "name" => "Fibra móvil y TV",
                        "url" => "/internet-telefonia/comparador-fibra-movil-tv"
                    ]
                ]
            ],
            [
                "title" => "TV y streaming",
                "titleUrl" => "/television-streaming",
                "children" => [
                    [
                        "name" => "Plataformas de streaming",
                        "url" => "/television-streaming/comparador-plataformas-streaming"
                    ]
                ]
            ],
            [
                "title" => "Energía",
                "titleUrl" => "/energia",
                "children" => [
                    [
                        "name" => "Luz",
                        "url" => "/energia/comparador-tarifas-luz"
                    ],
                    [
                        "name" => "Gas",
                        "url" => "/energia/comparador-tarifas-gas"
                    ],
                    [
                        "name" => "Luz y gas",
                        "url" => "/energia/comparador-tarifas-luz-y-gas"
                    ]
                ]
            ],
            [
                "title" => "Herramientas",
                "titleUrl" => "/herramientas",
                "children" => [
                    [
                        "name" => "Precio de la luz hoy",
                        "url" => "/herramientas/precio-de-la-luz-hoy"
                    ],
                    [
                        "name" => "Test de velocidad",
                        "url" => "/herramientas/test-de-velocidad"
                    ]
                ]
            ]
        ];
    }

    /* funciones para consultar las ofertas comerciales */
    public function getComercializadorasLuzList()
    {
        return DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado','=','1')
            ->where($this->tabla_luz.'.estado','=','1')
            ->groupBy($this->tabla_luz . '.comercializadora')
            ->get();
    }

    public function getComercializadorasGasList()
    {
        return DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado','=','1')
            ->where($this->tabla_gas.'.estado','=','1')
            ->groupBy($this->tabla_gas . '.comercializadora')
            ->get();
    }

    public function getOperadorasMovilList()
    {
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.estado','=','1')
            ->where($this->tabla_movil.'.estado','=','1')
            ->groupBy('operadora')
            ->get();
    }

    public function getOperadorasFibraList()
    {
        return DB::table($this->tabla_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.estado','=','1')
            ->where($this->tabla_fibra.'.estado','=','1')
            ->groupBy('operadora')
            ->get();
    }

    public function getComercializadorasLuzGasList()
    {
        return DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado','=','1')
            ->where($this->tabla_luz_gas.'.estado','=','1')
            ->groupBy('comercializadora')
            ->get();
    }

    public function getOperadorasFibraMovilList()
    {
        return DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.estado','=','1')
            ->where($this->tabla_movil_fibra.'.estado','=','1')
            ->groupBy('operadora')
            ->get();
    }

    public function getOperadorasFibraMovilTvList()
    {
        return DB::table($this->tabla_movil_fibra_tv)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra_tv . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.estado','=','1')
            ->where($this->tabla_movil_fibra_tv.'.estado','=','1')
            ->groupBy('operadora')
            ->get();
    }
}
