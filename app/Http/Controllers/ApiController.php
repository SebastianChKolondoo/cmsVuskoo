<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comercios;
use App\Models\Cupones;
use Illuminate\Support\Facades\DB;
use App\Models\PaginaWebFooter;
use App\Models\Paises;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
    protected $tabla_vehiculos;
    protected $tabla_vehiculo;
    protected $tabla_cupones;
    protected $tabla_autoconsumo;

    protected $tablaMap;
    protected $tablaPadre;

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

        $this->tabla_vehiculo = 'WEB_3_VEHICULOS';
        $this->tabla_vehiculos = '1_vehiculos';

        $this->tabla_cupones = 'WEB_3_TARIFAS_CUPONES';

        $this->tabla_autoconsumo = 'WEB_3_TARIFAS_ENERGIA_AUTOCONSUMO';

        // Inicializar mapeo de tablas
        $this->tablaMap = [
            'luz' => 'WEB_3_TARIFAS_ENERGIA_LUZ',
            'gas' => 'WEB_3_TARIFAS_ENERGIA_GAS',
            'luzgas' => 'WEB_3_TARIFAS_ENERGIA_LUZ_GAS',
            'autoconsumo' => 'WEB_3_TARIFAS_ENERGIA_AUTOCONSUMO',
            'movil' => 'WEB_3_TARIFAS_TELCO_MOVIL',
            'movilfibra' => 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL',
            'movilfibratv' => 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL_TV',
            'fibra' => 'WEB_3_TARIFAS_TELCO_FIBRA',
            'tv' => 'WEB_3_TARIFAS_TELCO_TV',
            'vehiculos' => '1_vehiculos',
            'vehiculo' => 'WEB_3_VEHICULOS',
            'cupones' => 'WEB_3_TARIFAS_CUPONES',
            'autoconsumo' => 'WEB_3_TARIFAS_ENERGIA_AUTOCONSUMO',
        ];

        $this->tablaPadre = [
            'comercializadora' => '1_comercializadoras',
            'operadora' => '1_operadoras',
        ];
    }

    public function index()
    {
        return view('swagger');
    }

    public function getMenuApi($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        // Realizar la consulta SQL para obtener los datos
        $rows = DB::table('pagina_web_menu')
            ->leftJoin('pagina_web_menu_item', 'pagina_web_menu_item.idMenu', '=', 'pagina_web_menu.id')
            ->select('pagina_web_menu.id as menuId', 'pagina_web_menu.titulo', 'pagina_web_menu.urlTitulo', 'pagina_web_menu_item.nombre', 'pagina_web_menu_item.url')
            ->where('pagina_web_menu.pais', $idioma->id)
            ->get();

        // Estructurar los datos para coincidir con la estructura JSON deseada
        $menuItems = [];

        foreach ($rows as $row) {
            $menuId = $row->menuId;
            if (!isset($menuItems[$menuId])) {
                $menuItems[$menuId] = [
                    'title' => $row->titulo,
                    'titleUrl' => $row->urlTitulo,
                    'children' => []
                ];
            }
            if ($row->nombre && $row->url) {
                $menuItems[$menuId]['children'][] = [
                    'name' => $row->nombre,
                    'url' => $row->url
                ];
            }
        }

        $data = array_values($menuItems);

        // Retornar la estructura en formato JSON
        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    
    /* NUEVA */
    public function getComercializadorasList($filtro, $lang = 'es')
    {
        if (!isset($this->tablaMap[strtolower($filtro)])) {
            return response()->json(['error' => 'Filtro inválido'], 400);
        }

        $tabla = $this->tablaMap[strtolower($filtro)];

        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }

        $tablaPadre = '1_comercializadoras';
        $filtroTablaPadre = 'comercializadora';

        return DB::table($tabla)
            ->join($tablaPadre, "{$tablaPadre}.id", '=', "{$tabla}.{$filtroTablaPadre}")
            ->select("{$tablaPadre}.id", "{$tablaPadre}.nombre", "{$tablaPadre}.logo")
            ->where("{$tablaPadre}.estado", '=', '1')
            ->where("{$tablaPadre}.pais", '=', $idioma->id)
            ->where("{$tabla}.estado", '=', '1')
            ->groupBy("{$tabla}.{$filtroTablaPadre}")
            ->get();
    }

    public function getOperadorasList($filtro, $lang = 'es')
    {
        if (!isset($this->tablaMap[strtolower($filtro)])) {
            return response()->json(['error' => 'Filtro inválido'], 400);
        }

        $tabla = $this->tablaMap[strtolower($filtro)];

        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }

        $tablaPadre = '1_operadoras';
        $filtroTablaPadre = 'operadora';

        return DB::table($tabla)
            ->join($tablaPadre, "{$tablaPadre}.id", '=', "{$tabla}.{$filtroTablaPadre}")
            ->select("{$tablaPadre}.id", "{$tablaPadre}.nombre", "{$tablaPadre}.logo")
            ->where("{$tablaPadre}.estado", '=', '1')
            ->where("{$tablaPadre}.pais", '=', $idioma->id)
            ->where("{$tabla}.estado", '=', '1')
            ->groupBy("{$tabla}.{$filtroTablaPadre}")
            ->get();
    }


    public function getComercializadorasLuzList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_luz)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado', '=', '1')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->where($this->tabla_luz . '.estado', '=', '1')
            ->groupBy($this->tabla_luz . '.comercializadora')
            ->get();
    }

    function buscadorCuponesFiltro($filtro){
        $comercios = Comercios::where('nombre', 'LIKE', '%'.$filtro.'%')->get();
        $cupones = Cupones::where('titulo', 'LIKE', '%'.$filtro.'%')->orWhere('descripcion', 'LIKE', '%'.$filtro.'%')->get();

        return [
            'comercios' => $comercios,
            'cupones' => $cupones
        ];
    }

    public function getComerciosCuponesList($lang = null, $idCategoria = null)
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }

        $idCategoriaConsulta = 0;
        if (!is_null($idCategoria) && $idCategoria !== 'null' && $idCategoria !== 'undefined') {
            $categoria = Categorias::where('nombre', $idCategoria)->first();
            if (!$categoria) {
                return [];
            }
            $idCategoriaConsulta = $categoria->id;
        }

        $query = DB::table($this->tabla_cupones)
            ->join('1_comercios', '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->select('1_comercios.id', '1_comercios.nombre', '1_comercios.logo')
            ->where('1_comercios.estado', '=', '1')
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->whereDate($this->tabla_cupones . '.fecha_inicial', '<=', now())
            ->whereDate($this->tabla_cupones . '.fecha_final', '>=', now())
            ->groupBy($this->tabla_cupones . '.comercio');

        if ($idCategoriaConsulta > 0) {
            $query->where($this->tabla_cupones . '.categoria', '=', $idCategoriaConsulta);
        }

        return $query->get();
    }


    public function getCategoriasCuponesList($lang = null)
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }


        $query = DB::table('1_comercios')
            ->select('traduccion_categorias.nombre as nombreCategoria', 'traduccion_categorias.categoria as idCategoria')
            ->where('1_comercios.estado', '=', 1)
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->join($this->tabla_cupones, '1_comercios.id', '=', $this->tabla_cupones . '.comercio')
            ->join('categorias_comercios', '1_comercios.categoria', '=', 'categorias_comercios.id')
            ->whereDate($this->tabla_cupones . '.fecha_inicial', '<=', DB::raw('CURRENT_DATE'))
            ->whereDate($this->tabla_cupones . '.fecha_final', '>=', DB::raw('CURRENT_DATE'))
            ->join('traduccion_categorias', 'traduccion_categorias.categoria', 'categorias_comercios.id')
            ->groupBy('1_comercios.categoria');

        return $query->get();
    }

    public function getTipoCuponesList($lang = 1, $idCategoria = null)
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        $categoria = '';
        /* $idCategoriaConsulta = 0;
        if ($idCategoria != null && $idCategoria != 'null' && $idCategoria != 'undefined') {
            $categoria = Categorias::where('nombre', $idCategoria)->count();
            if ($categoria == 0) {
                return [];
            } else {
                $categoria = Categorias::where('nombre', $idCategoria)->first();
                $idCategoriaConsulta = $categoria->id;
            }
        } */

        return $cupones = DB::table($this->tabla_cupones)
            ->join('TipoCupon', 'TipoCupon.id', '=', $this->tabla_cupones . '.tipoCupon')
            ->select('TipoCupon.id', 'TipoCupon.nombre')
            ->where($this->tabla_cupones . '.estado', '=', '1')
            ->where($this->tabla_cupones . '.pais', '=', $idioma->id)
            ->whereDate($this->tabla_cupones . '.fecha_inicial', '<=', DB::raw('CURRENT_DATE'))
            ->whereDate($this->tabla_cupones . '.fecha_final', '>=', DB::raw('CURRENT_DATE'))
            ->groupBy($this->tabla_cupones . '.tipoCupon')
            ->get();
    }

    public function getComercializadorasGasList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_gas . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado', 1)
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->where($this->tabla_gas . '.estado', '=', '1')
            ->groupBy($this->tabla_gas . '.comercializadora')
            ->get();
    }

    public function getComercializadoraAutoconsumoList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_autoconsumo)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_autoconsumo . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.estado', 1)
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->where($this->tabla_autoconsumo . '.estado', '=', '1')
            ->groupBy($this->tabla_autoconsumo . '.comercializadora')
            ->get();
    }

    public function getOperadorasAllList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table('1_operadoras')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->where('1_operadoras.estado', 1)
            ->get();
    }
    
    public function getComercializadorasAllList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table('1_comercializadoras')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->where('1_comercializadoras.estado', 1)
            ->get();
    }

    public function getOperadorasFibraList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_fibra . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where($this->tabla_fibra . '.estado', '=', '1')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->where('1_operadoras.estado', 1)
            ->groupBy('operadora')
            ->get();
    }


    public function getComercializadorasLuzGasList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_luz_gas)
            ->join('1_comercializadoras', '1_comercializadoras.id', '=', $this->tabla_luz_gas . '.comercializadora')
            ->select('1_comercializadoras.id', '1_comercializadoras.nombre', '1_comercializadoras.logo')
            ->where('1_comercializadoras.pais', '=', $idioma->id)
            ->where('1_comercializadoras.estado', 1)
            ->where($this->tabla_luz_gas . '.estado', '=', '1')
            ->groupBy('comercializadora')
            ->get();
    }

    public function getOperadorasFibraMovilList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_movil_fibra)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->where('1_operadoras.estado', 1)
            ->where($this->tabla_movil_fibra . '.estado', '=', '1')
            ->groupBy('operadora')
            ->get();
    }

    public function getOperadorasFibraMovilTvList($lang = 'es')
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_movil_fibra_tv)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil_fibra_tv . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->where('1_operadoras.estado', 1)
            ->where($this->tabla_movil_fibra_tv . '.estado', '=', '1')
            ->groupBy('operadora')
            ->get();
    }

    /* MX */

    public function getOperadorasPlanCelularList($lang = 3)
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_movil)
            ->join('1_operadoras', '1_operadoras.id', '=', $this->tabla_movil . '.operadora')
            ->select('1_operadoras.id', '1_operadoras.nombre', '1_operadoras.logo')
            ->where('1_operadoras.pais', '=', $idioma->id)
            ->where('1_operadoras.estado', 1)
            ->where($this->tabla_movil . '.estado', '=', '1')
            ->groupBy('operadora')
            ->get();
    }

    public function getMarcasVehiculosList($lang = 3)
    {
        $idioma = Paises::where('codigo', $lang)->first();
        if (!$idioma) {
            return [];
        }
        return DB::table($this->tabla_vehiculos)
            ->where('1_vehiculos.pais', '=', $idioma->id)
            ->where($this->tabla_vehiculos . '.estado', '=', '1')
            ->orderBy('nombre', 'asc')
            ->get();
    }

    public function getMetaSeoList($lang = null)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        return Paises::where('codigo', $lang)->first();
    }

    public function cargarPaisesCupones($id)
    {
        $data = DB::table('1_comercios')
            ->select('pais', 'categoria')
            ->where('1_comercios.id', '=', $id)
            ->orderBy('nombre', 'asc')
            ->first();

        if (!$data) {
            return [
                'paises' => ['nombre' => 'no disponible'],
                'categoria' => ['nombre' => 'no disponible'],
                'comercio' => ['nombre' => 'no disponible'],
            ];
        }

        // Obtiene la categoría
        $categoria = Categorias::select('*')->where('id', $data->categoria)->first();
        if (!$categoria->id) {
            return [
                'paises' => ['nombre' => 'no disponible'],
                'categoria' => ['nombre' => 'no disponible'],
                'comercio' => ['nombre' => 'no disponible'],
            ];
        }

        // Obtiene los países
        $paises = Paises::whereIn('id', is_array(json_decode($data->pais)) ? json_decode($data->pais) : [json_decode($data->pais)])->get();

        $comercio = Comercios::where('id', $id)->first();
        if (!$comercio->id) {
            return [
                'paises' => ['nombre' => 'no disponible'],
                'categoria' => ['nombre' => 'no disponible'],
                'comercio' => ['nombre' => 'no disponible'],
            ];
        }

        // Retorna ambos valores en un array asociativo
        return [
            'paises' => $paises,
            'categoria' => $categoria,
            'comercio' => $comercio,
        ];
    }


    public function cargarCategoriaMarca($id)
    {
        $data = DB::table('1_comercios')
            ->select('pais', 'categoria')
            ->where('1_comercios.id', '=', $id)
            ->orderBy('nombre', 'asc')
            ->first();

        return Paises::whereIn('id', is_array(json_decode($data->pais)) ? json_decode($data->pais) : [json_decode($data->pais)])->get();
    }

    public function cargarCategoriasPaisesCupones($lang)
    {
        $idioma = Paises::where('codigo', $lang)->first();

        return DB::table('categorias_comercios')
            ->where('categorias_comercios.pais', $idioma->id)
            ->where('traduccion_categorias.pais', $idioma->id)
            ->select('traduccion_categorias.nombre as nombreCategoria', 'traduccion_categorias.categoria as idCategoria')
            ->join('traduccion_categorias', 'traduccion_categorias.categoria', 'categorias_comercios.id')
            ->orderBy('categorias_comercios.nombre', 'asc')
            ->get();
    }

    public function getFooterList($lang = null)
    {
        $validacionPais = Paises::where('codigo', $lang)->count();
        if ($validacionPais == 0) {
            return [];
        }
        $validacionPais = Paises::where('codigo', $lang)->first();
        return PaginaWebFooter::where('pais', $validacionPais->id)->first();
    }

    public function getPricesByMonth()
    {
        $url = 'https://www.apaga-luz.com/data/group_prices_by_month.json';

        try {
            // Realizar la solicitud a la API externa
            $response = Http::withHeaders([
                'X-API-Key' => 'We0OfoTOgg46ISK', // Agregar el encabezado de autenticación si es necesario
                'Content-Type' => 'application/json',
            ])->get($url);

            // Retornar la respuesta al frontend
            return response($response->body(), $response->status())
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*'); // Esto permite solicitudes desde cualquier origen
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo obtener los datos'], 500);
        }
    }

    public function getPricesByNow()
    {
        // Obtener la fecha actual
        $fecha = Carbon::now();
        $año = $fecha->year;
        $mes = $fecha->month;
        $dia = $fecha->day;

        // Formatear la fecha
        $actual = "{$año}-{$mes}-{$dia}";

        try {
            // Realizar la solicitud a la API externa
            $url = "https://apidatos.ree.es/es/datos/mercados/precios-mercados-tiempo-real";
            $response = Http::get("{$url}?start_date={$actual}T00:00&end_date={$actual}T23:00&time_trunc=hour");

            // Retornar la respuesta al frontend
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo obtener los datos'], 500);
        }
    }


}
