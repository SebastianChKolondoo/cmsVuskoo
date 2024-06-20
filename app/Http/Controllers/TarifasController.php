<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Paises;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarifasController extends Controller
{
    protected $tabla_luz = 'WEB_3_TARIFAS_ENERGIA_LUZ';
    protected $tabla_gas = 'WEB_3_TARIFAS_ENERGIA_GAS';
    protected $tabla_luz_gas = 'WEB_3_TARIFAS_ENERGIA_LUZ_GAS';
    protected $tabla_movil = 'WEB_3_TARIFAS_TELCO_MOVIL';
    protected $tabla_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA';
    protected $tabla_tv = 'WEB_3_TARIFAS_TELCO_TV';
    protected $tabla_movil_fibra = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL';
    protected $tabla_movil_fibra_tv = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL_TV';
    protected $tabla_streaming = 'WEB_3_TARIFAS_TELCO_STREAMING';
    protected $tabla_vehiculo = 'WEB_3_VEHICULOS';
    protected $tabla_vehiculos = '1_vehiculos';
    protected $tabla_cupones = 'WEB_3_TARIFAS_CUPONES';
    protected $tabla_prestamos = 'WEB_3_PRESTAMOS';

    public function getTarifasMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasFibraList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_fibra)
            ->select($this->tabla_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->where($this->tabla_fibra . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'desc')
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasLuzList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->select($this->tabla_luz . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where($this->tabla_luz . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasGasList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->select($this->tabla_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where($this->tabla_gas . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasGasLuzList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->select($this->tabla_luz_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where($this->tabla_luz_gas . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasFibraMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->select($this->tabla_movil_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil_fibra . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getTarifasFibraMovilTvList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $query = DB::table($this->tabla_movil_fibra_tv)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra_tv . '.operadora')
            ->select($this->tabla_movil_fibra_tv . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil_fibra_tv . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_movil_fibra_tv . '.id', '=', $id);
        }

        return $query->get();
    }

    public function getTarifasVehiculosList($lang = 'mx')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $query = DB::table($this->tabla_vehiculo)
            ->join('1_vehiculos', '1_vehiculos.id', '=', $this->tabla_vehiculo . '.vehiculo')
            ->select($this->tabla_vehiculo . '.id', $this->tabla_vehiculo . '.vehiculo', $this->tabla_vehiculo . '.transmission', $this->tabla_vehiculo . '.hp', $this->tabla_vehiculo . '.price', $this->tabla_vehiculo . '.year', $this->tabla_vehiculo . '.chassis', $this->tabla_vehiculo . '.make', $this->tabla_vehiculo . '.model', $this->tabla_vehiculo . '.landingLead', $this->tabla_vehiculo . '.slug_tarifa', $this->tabla_vehiculo . '.fuelType', $this->tabla_vehiculo . '.images', '1_vehiculos.nombre', '1_vehiculos.logo')
            ->where($this->tabla_vehiculo . '.estado', '=', '1')
            ->where('1_vehiculos.estado', '=', '1')
            ->where('1_vehiculos.pais', '=', $idioma->id)
            ->orderBy('price', 'desc');

        if (!empty($id)) {
            $query->where($this->tabla_movil_fibra_tv . '.id', '=', $id);
        }

        return $query->get();
    }

    public function getTarifasCuponesList($lang = 'es', $idCategoria = null)
    {
        $idCategoriaConsulta = 0;
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();

        if ($idCategoria != null && $idCategoria != 'null') {
            $categoria = Categorias::where('nombre', $idCategoria)->count();
            if ($categoria == 0) {
                return [];
            } else {
                $categoria = Categorias::where('nombre', $idCategoria)->first();
                $idCategoriaConsulta = $categoria->id;
            }
        }

        $query = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->select(
                $this->tabla_cupones . '.*',
                DB::raw('DATE_FORMAT(fecha_expiracion, "%d-%m-%Y") as fecha_expiracion'),
                DB::raw('DATEDIFF(fecha_expiracion, CURRENT_DATE) AS dias_restantes'),
                '1_comercios.nombre as nombre_comercio',
                '1_comercios.logo',
                'paises.nombre as pais',
                'TipoCupon.nombre as cupon',
                'categorias_comercios.nombre as categoria_nombre'
            )
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
            ->join('paises', 'paises.id', '=', $this->tabla_cupones . '.pais')
            ->join('categorias_comercios', 'categorias_comercios.id', '=', $this->tabla_cupones . '.categoria')
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where('1_comercios.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->where($this->tabla_cupones . '.fecha_expiracion', '>=', DB::raw('CURRENT_DATE'))
            ->orderBy('destacada', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_cupones . '.id', '=', $id);
        }

        if ($idCategoriaConsulta != 0) {
            $query->where('categoria', $idCategoriaConsulta);
        }

        return $query->get();
    }

    public function getTarifaCuponList($id)
    {
        $query = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->select($this->tabla_cupones . '.*', DB::raw('DATE_FORMAT(fecha_expiracion, "%d-%m-%Y") as fecha_expiracion'), DB::raw('DATEDIFF(fecha_expiracion, CURRENT_DATE) AS dias_restantes'), '1_comercios.nombre as nombre_comercio', '1_comercios.logo', 'paises.nombre as pais', 'TipoCupon.nombre as cupon')
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
            ->join('paises', 'paises.id', $this->tabla_cupones . '.pais')
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where('1_comercios.estado', '=', '1')
            ->where($this->tabla_cupones . '.id', $id)
            ->orderBy('destacada', 'asc');

        return $query->first();
    }

    public function getTarifasStreamingList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $query = DB::table($this->tabla_streaming)
            ->select('*')
            ->where('estado', 1)
            ->where('pais', $idioma->id)
            ->orderBy('destacada', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_streaming . '.id', '=', $id);
        }

        return $query->get();
    }

    public function getDetailOfferMovilList($id)
    {
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferLuzList($id)
    {
        return DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->select($this->tabla_luz . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_luz . '.comercializadora as operadora')
            ->where($this->tabla_luz . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferGasList($id)
    {
        return DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->select($this->tabla_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_gas . '.comercializadora as operadora')
            ->where($this->tabla_gas . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferGasLuzList($id)
    {
        return DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->select($this->tabla_luz_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_luz_gas . '.comercializadora as operadora')
            ->where($this->tabla_luz_gas . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferFibraList($id)
    {
        return DB::table($this->tabla_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->select($this->tabla_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo', '1_operadoras.politica_privacidad')
            ->where($this->tabla_fibra . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferFibraMovilList($id)
    {
        return DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->select($this->tabla_movil_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil_fibra . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferFibraMovilTvList($id)
    {
        return DB::table($this->tabla_movil_fibra_tv)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra_tv . '.operadora')
            ->select($this->tabla_movil_fibra_tv . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil_fibra_tv . '.id', '=', $id)
            ->first();
    }

    /* Mexico */
    public function getTarifasPlanCelularList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();
    }

    public function getDetailOfferPlanCelularList($id)
    {
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_movil . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferVehiculosList($id)
    {
        return DB::table($this->tabla_vehiculo)
            ->join('1_vehiculos', '1_vehiculos.id', '=', $this->tabla_vehiculo . '.vehiculo')
            ->select($this->tabla_vehiculo . '.*', '1_vehiculos.nombre', '1_vehiculos.logo')
            ->where($this->tabla_vehiculo . '.id', '=', $id)
            ->first();
    }

    public function getTarifasPrestamosList($lang = 'co')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $query = DB::table($this->tabla_prestamos)
            ->join('1_banca', '1_banca.id', '=', $this->tabla_prestamos . '.banca')
            ->select($this->tabla_prestamos . '.*', '1_banca.nombre', '1_banca.logo')
            ->where($this->tabla_prestamos . '.estado', '=', '1')
            ->orderBy('destacada', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_prestamos . '.id', '=', $id);
        }

        return $query->get();
    }

    public function getTarifaPrestamoList($id = null)
    {
        $query = DB::table($this->tabla_prestamos)
            ->join('1_banca', '1_banca.id', '=', $this->tabla_prestamos . '.banca')
            ->select($this->tabla_prestamos . '.*', '1_banca.nombre', '1_banca.logo')
            ->where($this->tabla_prestamos . '.estado', '=', '1')
            ->orderBy('destacada', 'asc');

        if (!empty($id) && $id != null) {
            $query->where($this->tabla_prestamos . '.id', '=', $id);
        }

        return $query->first();
    }
}
