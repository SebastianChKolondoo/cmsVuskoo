<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Paises;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

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
    protected $tabla_alarmas = 'WEB_3_TARIFAS_ALARMAS';
    protected $tabla_seguro_salud = 'WEB_3_TARIFAS_SEGUROS_SALUD';

    public function conversorValor($valor, $decimal, $pais)
    {
        switch ($pais) {
            case 1: //españa
            case 3: //mexico
                return (float) str_replace(['.', ','], ['', '.'], number_format($valor, $decimal, ',', '.'));

                break;
            case 2: //colombia
                return (int) str_replace('.', '', $valor);

                break;
        }
    }

    public function getTarifasMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data = DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'paises.decimales')
            ->where($this->tabla_movil . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            // Eliminar los puntos y comas del string formateado para volver a convertirlo en numérico
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
            $item->coste_llamadas_minuto = $this->conversorValor($item->coste_llamadas_minuto, $item->decimales, $item->pais);
            $item->coste_establecimiento_llamada = $this->conversorValor($item->coste_establecimiento_llamada, $item->decimales, $item->pais);
        }

        return $data;
    }

    public function getTarifasFibraList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data = DB::table($this->tabla_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'paises.decimales')
            ->where($this->tabla_fibra . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            // Eliminar los puntos y comas del string formateado para convertirlo a numérico
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
        }

        return $data;
    }

    public function getTarifasLuzList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data = DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_luz . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', 'paises.decimales')
            ->where($this->tabla_luz . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
            $item->coste_mantenimiento = $this->conversorValor($item->coste_mantenimiento, $item->decimales, $item->pais);
            $item->coste_de_gestion = $this->conversorValor($item->coste_de_gestion, $item->decimales, $item->pais);
        }
        return $data;
    }

    public function getTarifasGasList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data = DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', 'paises.decimales')
            ->where($this->tabla_gas . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
            $item->coste_mantenimiento = $this->conversorValor($item->coste_mantenimiento, $item->decimales, $item->pais);
            $item->coste_de_gestion = $this->conversorValor($item->coste_de_gestion, $item->decimales, $item->pais);
            $item->gas_precio_termino_fijo = $this->conversorValor($item->gas_precio_termino_fijo, $item->decimales, $item->pais);
            $item->gas_precio_energia = $this->conversorValor($item->gas_precio_energia, $item->decimales, $item->pais);
        }
        return $data;
    }

    public function getTarifasGasLuzList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data =  DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_luz_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', 'paises.decimales')
            ->where($this->tabla_luz_gas . '.estado', '=', '1')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            // Formatear los números y luego convertirlos de nuevo a numérico
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
            $item->coste_mantenimiento = $this->conversorValor($item->coste_mantenimiento, $item->decimales, $item->pais);
            $item->coste_de_gestion = $this->conversorValor($item->coste_de_gestion, $item->decimales, $item->pais);
            $item->gas_precio_termino_fijo = $this->conversorValor($item->gas_precio_termino_fijo, $item->decimales, $item->pais);
            $item->gas_precio_energia = $this->conversorValor($item->gas_precio_energia, $item->decimales, $item->pais);
        }
        return $data;
    }

    public function getTarifasFibraMovilList($lang = 'es')
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();
        $data = DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'paises.decimales')
            ->where($this->tabla_movil_fibra . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc')
            ->get();

        foreach ($data as $item) {
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = (int) str_replace(['.', ','], ['', '.'], number_format($item->precio_final, $item->decimales, ',', '.'));
        }

        return $data;
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
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil_fibra_tv . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'paises.decimales')
            ->where($this->tabla_movil_fibra_tv . '.estado', '=', '1')
            ->where('1_operadoras.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->orderBy('destacada', 'asc')
            ->orderBy('precio', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_movil_fibra_tv . '.id', '=', $id);
        }

        $data = $query->get();

        foreach ($data as $item) {
            // Formatear los números y luego convertirlos de nuevo a numérico
            $item->precio = $this->conversorValor($item->precio, $item->decimales, $item->pais);
            $item->precio_final = $this->conversorValor($item->precio_final, $item->decimales, $item->pais);
            $item->coste_llamadas_minuto = $this->conversorValor($item->coste_llamadas_minuto, $item->decimales, $item->pais);
            $item->coste_establecimiento_llamada = $this->conversorValor($item->coste_establecimiento_llamada, $item->decimales, $item->pais);
        }
        return $data;
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
            ->join('paises', 'paises.id', '=', '1_vehiculos.pais')
            ->select('paises.decimales', $this->tabla_vehiculo . '.id', $this->tabla_vehiculo . '.vehiculo', $this->tabla_vehiculo . '.transmission', $this->tabla_vehiculo . '.hp', $this->tabla_vehiculo . '.price', $this->tabla_vehiculo . '.year', $this->tabla_vehiculo . '.chassis', $this->tabla_vehiculo . '.make', $this->tabla_vehiculo . '.model', $this->tabla_vehiculo . '.landingLead', $this->tabla_vehiculo . '.slug_tarifa', $this->tabla_vehiculo . '.fuelType', $this->tabla_vehiculo . '.images', '1_vehiculos.nombre', '1_vehiculos.logo')
            ->where($this->tabla_vehiculo . '.estado', '=', '1')
            ->where('1_vehiculos.estado', '=', '1')
            ->where('1_vehiculos.pais', '=', $idioma->id)
            ->orderBy('price', 'desc');

        if (!empty($id)) {
            $query->where($this->tabla_movil_fibra_tv . '.id', '=', $id);
        }

        $data =  $query->get();

        return $data;
    }

    public function getTarifasCuponesDestacadosList($lang)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $idioma = Paises::where('codigo', $lang)->first();

        $data = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
            ->join('paises', 'paises.id', '=', $this->tabla_cupones . '.pais')
            ->join('categorias_comercios', 'categorias_comercios.id', '1_comercios.categoria')
            ->select(
                'paises.decimales',
                'paises.moneda',
                $this->tabla_cupones . '.*',
                DB::raw('CURRENT_DATE'),
                DB::raw('DATE_FORMAT(' . $this->tabla_cupones . '.fecha_final, "%d-%m-%Y") as fecha_final'),
                DB::raw('DATEDIFF(' . $this->tabla_cupones . '.fecha_final, CURRENT_DATE) AS dias_restantes'),
                '1_comercios.nombre as nombre_comercio',
                '1_comercios.logo',
                'paises.nombre as pais',
                'TipoCupon.nombre as cupon',
                'categorias_comercios.nombre as categoriaItem'
            )
            ->where($this->tabla_cupones . '.destacada', '=', '2')
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where('1_comercios.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->whereDate($this->tabla_cupones . '.fecha_inicial', '<=', DB::raw('CURRENT_DATE'))
            ->whereDate($this->tabla_cupones . '.fecha_final', '>=', DB::raw('CURRENT_DATE'))
            ->orderBy('id', 'asc')
            ->get();

        return $data;
    }

    public function getTarifasCuponesList($lang = '', $idCategoria = null)
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
                $categoria = Categorias::where('nombre', strtolower($idCategoria))->first();
                $idCategoriaConsulta = $categoria->id;
            }
        }

        $query = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
            ->join('paises', 'paises.id', '=', $this->tabla_cupones . '.pais')
            ->join('categorias_comercios', 'categorias_comercios.id', '1_comercios.categoria')
            ->select(
                'paises.decimales',
                'paises.moneda',
                $this->tabla_cupones . '.*',
                DB::raw('CURRENT_DATE'),
                DB::raw('DATE_FORMAT(' . $this->tabla_cupones . '.fecha_final, "%d-%m-%Y") as fecha_final'),
                DB::raw('DATEDIFF(' . $this->tabla_cupones . '.fecha_final, CURRENT_DATE) AS dias_restantes'),
                '1_comercios.nombre as nombre_comercio',
                '1_comercios.logo',
                'paises.nombre as pais',
                'TipoCupon.nombre as cupon',
                'categorias_comercios.nombre as categoriaItem'
            )
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where('1_comercios.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->whereDate($this->tabla_cupones . '.fecha_inicial', '<=', DB::raw('CURRENT_DATE'))
            ->whereDate($this->tabla_cupones . '.fecha_final', '>=', DB::raw('CURRENT_DATE'))
            ->orderBy('destacada', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_cupones . '.id', '=', $id);
        }

        if ($idCategoriaConsulta != null) {
            $query->where('1_comercios.categoria', '=', $idCategoriaConsulta);
        }

        return $query->get();
    }


    public function getTarifaCuponList($id)
    {
        $query = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->join('paises', 'paises.id', $this->tabla_cupones . '.pais')
            ->select('paises.decimales', $this->tabla_cupones . '.*', DB::raw('DATE_FORMAT(fecha_final, "%d-%m-%Y") as fecha_final'), DB::raw('DATEDIFF(fecha_final, CURRENT_DATE) AS dias_restantes'), '1_comercios.nombre as nombre_comercio', '1_comercios.logo', 'paises.nombre as pais', 'TipoCupon.nombre as cupon')
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
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
            ->select('*', 'paises.decimales')
            ->join('paises', 'paises.id', $this->tabla_streaming . '.pais')
            ->where($this->tabla_streaming . '.estado', 1)
            ->where('pais', $idioma->id)
            ->orderBy($this->tabla_streaming . '.destacada', 'asc');

        if (!empty($id)) {
            $query->where($this->tabla_streaming . '.id', '=', $id);
        }

        $data = $query->get();

        foreach ($data as $item) {
            // Formatear los números y luego convertirlos de nuevo a numérico
            $item->precio_relativo_1 = $this->conversorValor($item->precio_relativo_1, $item->decimales, $item->pais);
            $item->precio_relativo_2 = $this->conversorValor($item->precio_relativo_2, $item->decimales, $item->pais);
            $item->precio_relativo_3 = $this->conversorValor($item->precio_relativo_3, $item->decimales, $item->pais);
            $item->precio_parrilla_bloque_1 = $this->conversorValor($item->precio_parrilla_bloque_1, $item->decimales, $item->pais);
            $item->precio_parrilla_bloque_2 = $this->conversorValor($item->precio_parrilla_bloque_2, $item->decimales, $item->pais);
            $item->precio_parrilla_bloque_3 = $this->conversorValor($item->precio_parrilla_bloque_3, $item->decimales, $item->pais);
            $item->precio_parrilla_bloque_4 = $this->conversorValor($item->precio_parrilla_bloque_4, $item->decimales, $item->pais);
        }

        return $data;
    }

    public function getDetailOfferMovilList($id)
    {
        $data = DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_movil . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = number_format($data->precio, $data->decimales, ',', '.');
        }

        if (isset($data->precio_final)) {
            $data->precio_final = number_format($data->precio_final, $data->decimales, ',', '.');
        }

        return $data;
    }

    public function getDetailOfferLuzList($id)
    {
        $data =  DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_luz . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_luz . '.comercializadora as operadora', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_luz . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }

        if (isset($data->coste_mantenimiento)) {
            $data->coste_mantenimiento = $this->conversorValor($data->coste_mantenimiento, $data->decimales, $data->pais);
        }

        if (isset($data->coste_de_gestion)) {
            $data->coste_de_gestion = $this->conversorValor($data->coste_de_gestion, $data->decimales, $data->pais);
        }

        return $data;
    }

    public function getDetailOfferGasList($id)
    {
        $data = DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_gas . '.comercializadora as operadora', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_gas . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }

        if (isset($data->coste_mantenimiento)) {
            $data->coste_mantenimiento = $this->conversorValor($data->coste_mantenimiento, $data->decimales, $data->pais);
        }

        if (isset($data->coste_de_gestion)) {
            $data->coste_de_gestion = $this->conversorValor($data->coste_de_gestion, $data->decimales, $data->pais);
        }

        return $data;
    }

    public function getDetailOfferGasLuzList($id)
    {
        $data = DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->join('paises', 'paises.id', '=', '1_comercializadoras.pais')
            ->select($this->tabla_luz_gas . '.*', '1_comercializadoras.nombre', '1_comercializadoras.logo', $this->tabla_luz_gas . '.comercializadora as operadora', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_luz_gas . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }

        if (isset($data->coste_mantenimiento)) {
            $data->coste_mantenimiento = $this->conversorValor($data->coste_mantenimiento, $data->decimales, $data->pais);
        }

        if (isset($data->coste_de_gestion)) {
            $data->coste_de_gestion = $this->conversorValor($data->coste_de_gestion, $data->decimales, $data->pais);
        }

        return $data;
    }

    public function getDetailOfferFibraList($id)
    {
        $data = DB::table($this->tabla_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo', '1_operadoras.politica_privacidad', 'paises.decimales')
            ->where($this->tabla_fibra . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }

        return $data;
    }

    public function getDetailOfferFibraMovilList($id)
    {
        $data = DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil_fibra . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_movil_fibra . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }

        return $data;
    }

    public function getDetailOfferFibraMovilTvList($id)
    {
        $data = DB::table($this->tabla_movil_fibra_tv)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra_tv . '.operadora')
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil_fibra_tv . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_movil_fibra_tv . '.id', '=', $id)
            ->first();

        if (isset($data->precio)) {
            $data->precio = $this->conversorValor($data->precio, $data->decimales, $data->pais);
        }

        if (isset($data->precio_final)) {
            $data->precio_final = $this->conversorValor($data->precio_final, $data->decimales, $data->pais);
        }


        return $data;
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
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select('paises.decimales', $this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'paises.decimales')
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
            ->join('paises', 'paises.id', '=', '1_operadoras.pais')
            ->select($this->tabla_movil . '.*', '1_operadoras.nombre', '1_operadoras.logo', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_movil . '.id', '=', $id)
            ->first();
    }

    public function getDetailOfferVehiculosList($id)
    {
        return DB::table($this->tabla_vehiculo)
            ->join('1_vehiculos', '1_vehiculos.id', '=', $this->tabla_vehiculo . '.vehiculo')
            ->join('paises', 'paises.id', '=', '1_vehiculos.pais')
            ->select($this->tabla_vehiculo . '.*', '1_vehiculos.nombre', '1_vehiculos.logo', 'politica_privacidad', 'paises.decimales')
            ->where($this->tabla_vehiculo . '.id', '=', $id)
            ->first();
    }

    public function getTarifasPrestamosList($lang = 'co', $categoria = null)
    {

        if ($categoria != null) {
            $validacionPais = Paises::where('codigo', $lang)->count();
            if ($validacionPais == 0) {
                return [];
            }

            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_prestamos)
                ->join('1_banca', '1_banca.id', '=', $this->tabla_prestamos . '.banca')
                ->join('paises', 'paises.id', '=', '1_banca.pais')
                ->select($this->tabla_prestamos . '.*', '1_banca.nombre', '1_banca.logo', 'paises.decimales')
                ->where($this->tabla_prestamos . '.estado', '=', '1')
                ->where($this->tabla_prestamos . '.categoria', '=', $categoria)
                ->where('1_banca.pais', $idioma->id)
                ->orderBy('destacada', 'asc');

            if (!empty($id)) {
                $query->where($this->tabla_prestamos . '.id', '=', $id);
            }

            return $query->get();
        } else {
            return [];
        }
    }

    public function getTarifaPrestamoList($id = null)
    {
        $query = DB::table($this->tabla_prestamos)
            ->join('1_banca', '1_banca.id', '=', $this->tabla_prestamos . '.banca')
            ->join('paises', 'paises.id', '=', '1_comercios.pais')
            ->select($this->tabla_prestamos . '.*', '1_banca.nombre', '1_banca.logo', 'paises.decimales')
            ->where($this->tabla_prestamos . '.estado', '=', '1')
            ->orderBy('destacada', 'asc');

        if (!empty($id) && $id != null) {
            $query->where($this->tabla_prestamos . '.id', '=', $id);
        }

        return $query->first();
    }

    public function getBancasPrestamosList($lang = 'co', $categoria = null)
    {
        if ($categoria != null) {
            $validacionPais = Paises::where('codigo', $lang)->count();
            if ($validacionPais == 0) {
                return [];
            }

            $idioma = Paises::where('codigo', $lang)->first();
            return DB::table($this->tabla_prestamos)
                ->join('1_banca', '1_banca.id', '=', $this->tabla_prestamos . '.banca')
                ->join('paises', 'paises.id', '=', '1_banca.pais')
                ->select('1_banca.nombre', '1_banca.id', '1_banca.logo', 'paises.decimales')
                ->where('1_banca.pais', $idioma->id)
                ->where($this->tabla_prestamos . '.estado', '=', '1')
                ->where($this->tabla_prestamos . '.categoria', '=', $categoria)
                ->groupBy('1_banca.nombre')
                ->orderBy('destacada', 'asc')
                ->get();
        } else {
            return [];
        }
    }

    public function getTarifasAlarmasList($lang)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        if ($validacionPais == 1) {
            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_alarmas)
                ->join('1_proveedores', '1_proveedores.id', '=', $this->tabla_alarmas . '.proveedor')
                ->join('paises', 'paises.id', '=', '1_proveedores.pais')
                ->select('1_proveedores.nombre as proveedor_nombre', '1_proveedores.id  as proveedor_id', '1_proveedores.logo  as proveedor_logo', 'paises.decimales', $this->tabla_alarmas . '.*')
                ->where('1_proveedores.pais', $idioma->id)
                ->where($this->tabla_alarmas . '.estado', '=', '1')
                ->orderBy('destacada', 'asc');

            $data = $query->get();

            foreach ($data as $item) {
                // Formatear los números y luego convertirlos de nuevo a numérico
                $item->precio_1 = $this->conversorValor($item->precio_1, $item->decimales, $item->pais);
                $item->precio_2 = $this->conversorValor($item->precio_2, $item->decimales, $item->pais);
            }
            return $data;
        } else {
            return [];
        }
    }
    
    public function getTarifasSeguroSaludList($lang, $categoria)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        if ($categoria == null) {
            return [];
        }

        if ($validacionPais == 1) {
            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_seguro_salud)
                ->join('1_proveedores', '1_proveedores.id', '=', $this->tabla_seguro_salud . '.proveedor')
                ->join('paises', 'paises.id', '=', '1_proveedores.pais')
                ->select('1_proveedores.nombre as proveedor_nombre', '1_proveedores.id  as proveedor_id', '1_proveedores.logo  as proveedor_logo', 'paises.decimales', $this->tabla_seguro_salud . '.*')
                ->where('1_proveedores.pais', $idioma->id)
                ->where($this->tabla_seguro_salud . '.copago', $categoria)
                ->orderBy('destacada', 'asc');

            $data = $query->get();

            foreach ($data as $item) {
                // Formatear los números y luego convertirlos de nuevo a numérico
                $item->precio_1 = $this->conversorValor($item->precio_1, $item->decimales, $item->pais);
                $item->precio_2 = $this->conversorValor($item->precio_2, $item->decimales, $item->pais);
            }
            return $data;
        } else {
            return [];
        }
    }

    public function getTarifasComparadorCuotaMensualList($lang)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        if ($validacionPais == 1) {
            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_alarmas)
                ->join('1_proveedores', '1_proveedores.id', '=', $this->tabla_alarmas . '.proveedor')
                ->join('paises', 'paises.id', '=', '1_proveedores.pais')
                ->select('1_proveedores.nombre as proveedor_nombre', '1_proveedores.id  as proveedor_id', '1_proveedores.logo  as proveedor_logo', 'paises.decimales', $this->tabla_alarmas . '.*')
                ->where('1_proveedores.pais', $idioma->id)
                ->where($this->tabla_alarmas . '.estado', '=', '1')
                ->inRandomOrder()
                ->take(4);

            $data = $query->get();

            foreach ($data as $item) {
                // Formatear los números y luego convertirlos de nuevo a numérico
                $item->precio_1 = $this->conversorValor($item->precio_1, $item->decimales, $item->pais);
                $item->precio_2 = $this->conversorValor($item->precio_2, $item->decimales, $item->pais);
            }
            return $data;
        } else {
            return [];
        }
    }
    
    public function getTarifasComparadorSaludList($lang)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        if ($validacionPais == 1) {
            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_seguro_salud)
                ->join('1_proveedores', '1_proveedores.id', '=', $this->tabla_seguro_salud . '.proveedor')
                ->join('paises', 'paises.id', '=', '1_proveedores.pais')
                ->select('1_proveedores.nombre as proveedor_nombre', '1_proveedores.id  as proveedor_id', '1_proveedores.logo  as proveedor_logo', 'paises.decimales', $this->tabla_seguro_salud . '.*')
                ->where('1_proveedores.pais', $idioma->id)
                ->where('')
                ->where($this->tabla_seguro_salud . '.estado', '=', '1');

            $data = $query->get();

            foreach ($data as $item) {
                // Formatear los números y luego convertirlos de nuevo a numérico
                $item->precio_1 = $this->conversorValor($item->precio_1, $item->decimales, $item->pais);
                $item->precio_2 = $this->conversorValor($item->precio_2, $item->decimales, $item->pais);
            }
            return $data;
        } else {
            return [];
        }
    }
    
    public function getTarifasComparadorAlarmasEquiposList($lang)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        if ($validacionPais == 1) {
            $idioma = Paises::where('codigo', $lang)->first();
            $query = DB::table($this->tabla_alarmas)
                ->join('1_proveedores', '1_proveedores.id', '=', $this->tabla_alarmas . '.proveedor')
                ->join('paises', 'paises.id', '=', '1_proveedores.pais')
                ->select('1_proveedores.nombre as proveedor_nombre', '1_proveedores.id  as proveedor_id', '1_proveedores.logo  as proveedor_logo', 'paises.decimales', $this->tabla_alarmas . '.*')
                ->where('1_proveedores.pais', $idioma->id)
                ->where($this->tabla_alarmas . '.estado', '=', '1')
                ->inRandomOrder()
                ->take(4);

            $data = $query->get();

            foreach ($data as $item) {
                // Formatear los números y luego convertirlos de nuevo a numérico
                $item->precio_1 = $this->conversorValor($item->precio_1, $item->decimales, $item->pais);
                $item->precio_2 = $this->conversorValor($item->precio_2, $item->decimales, $item->pais);
            }
            return $data;
        } else {
            return [];
        }
    }
}
