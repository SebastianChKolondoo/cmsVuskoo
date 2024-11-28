<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CuponesController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExtraOfferController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TarifasController;
use App\Http\Controllers\UtilsController;
use App\Models\Comercios;
use App\Models\Cupones;

Route::get('/', function () {
    return 'welcome to Vuskoo!';
});

/* herramienta luz */
Route::get('groupPricesByMonth', [ApiController::class, 'getPricesByMonth']);
Route::get('pricesByNow', [ApiController::class, 'getPricesByNow']);

Route::get('emailtest', [EmailController::class, 'sendMail'])->name('emailtest');
Route::get('getBlogPreview/{id}', [BlogController::class, 'getBlogPreviewList']);

Route::middleware('api')->group(function () {
    Route::get('getOperadorasAll/{lang?}', [ApiController::class, 'getOperadorasAllList']);
    Route::get('getComercializadorasAll/{lang?}', [ApiController::class, 'getComercializadorasAllList']);

    /* NUEVA */
    Route::get('getComercializadoras/{filtro}/{lang?}', [ApiController::class, 'getComercializadorasList']);
    Route::get('getOperadoras/{filtro?}/{lang?}', [ApiController::class, 'getOperadorasList']);
    Route::get('getMetaDataSEO/{lang?}', [ApiController::class, 'getMetaSeoList']);

    Route::get('getComercializadorasLuzGas/{lang?}', [ApiController::class, 'getComercializadorasLuzGasList']);

    Route::get('getOperadorasPlanCelular/{lang?}', [ApiController::class, 'getOperadorasPlanCelularList']);
    Route::get('getComerciosCupones/{lang?}/{categoria?}', [ApiController::class, 'getComerciosCuponesList']);
    Route::get('getCategoriasCupones/{lang?}', [ApiController::class, 'getCategoriasCuponesList']);
    Route::get('getTipoCupones/{lang?}/{categoria?}', [ApiController::class, 'getTipoCuponesList']);

    Route::get('getTarifasLuz/{lang?}', [TarifasController::class, 'getTarifasLuzList']);
    Route::get('getExtraOfferluz/{lang?}', [ExtraOfferController::class, 'getExtraOfferLuzList']);
    Route::get('getDetailOffercomparadortarifasluz/{id}', [TarifasController::class, 'getDetailOfferLuzList']);
    /* Gas */
    Route::get('getTarifasGas/{lang?}', [TarifasController::class, 'getTarifasGasList']);
    Route::get('getExtraOffergas/{lang?}', [ExtraOfferController::class, 'getExtraOfferGasList']);
    Route::get('getDetailOffercomparadortarifasgas/{id}', [TarifasController::class, 'getDetailOfferGasList']);
    /* Luz y Gas */
    Route::get('getTarifasGasLuz/{lang?}', [TarifasController::class, 'getTarifasGasLuzList']);
    Route::get('getExtraOfferluzygas/{lang?}', [ExtraOfferController::class, 'getExtraOfferGasLuzList']);
    Route::get('getDetailOffercomparadortarifasluzygas/{id}', [TarifasController::class, 'getDetailOfferGasLuzList']);
    /* Luz Autoconsumo */
    Route::get('getTarifasAutoconsumo/{lang?}', [TarifasController::class, 'getTarifasAutoconsumoList']);
    Route::get('getExtraOffercomparadortarifasautoconsumo/{lang?}', [ExtraOfferController::class, 'getExtraOfferAutoconsumoList']);
    Route::get('getDetailOffercomparadortarifasautoconsumo/{id}', [TarifasController::class, 'getDetailOfferAutoconsumoList']);
    /* movil */
    Route::get('getTarifasMovil/{lang?}', [TarifasController::class, 'getTarifasMovilList']);
    Route::get('getfilterMovil/{lang?}', [FilterController::class, 'getValuesFilterMovilList']);
    Route::get('getExtraOffercomparadormovil/{lang?}', [ExtraOfferController::class, 'getExtraOfferMovilList']);
    Route::get('getDetailOffercomparadormovil/{id}', [TarifasController::class, 'getDetailOfferMovilList']);
    /* Fibra */
    Route::get('getTarifasFibra/{lang?}', [TarifasController::class, 'getTarifasFibraList']);
    Route::get('getfilterFibra/{lang?}', [FilterController::class, 'getValuesFilterFibraList']);
    Route::get('getExtraOffercomparadorfibra/{lang?}', [ExtraOfferController::class, 'getExtraOfferFibraList']);
    Route::get('getDetailOffercomparadorfibra/{id}', [TarifasController::class, 'getDetailOfferFibraList']);
    /* Fibra y Movil */
    Route::get('getTarifasFibraMovil/{lang?}', [TarifasController::class, 'getTarifasFibraMovilList']);
    Route::get('getfilterMovilFibra/{lang?}', [FilterController::class, 'getValuesFilterFibraMovilList']);
    Route::get('getExtraOffercomparadortarifasfibraymovil/{lang?}', [ExtraOfferController::class, 'getExtraOfferFibraMovilList']);
    Route::get('getDetailOffercomparadortarifasfibraymovil/{id}', [TarifasController::class, 'getDetailOfferFibraMovilList']);
    /* Fibra, Movil y TV */
    Route::get('getTarifasFibraMovilTv/{lang?}', [TarifasController::class, 'getTarifasFibraMovilTvList']);
    Route::get('getfilterMovilFibraTv/{lang?}', [FilterController::class, 'getValuesFilterFibraMovilTvList']);
    Route::get('getExtraOffercomparadorfibramoviltv/{lang?}', [ExtraOfferController::class, 'getExtraOfferFibraMovilTvList']);
    Route::get('getDetailOffercomparadorfibramoviltv/{id}', [TarifasController::class, 'getDetailOfferFibraMovilTvList']);
    /* Alarmas */
    Route::get('getTarifasAlarmas/{lang?}', [TarifasController::class, 'getTarifasAlarmasList']);
    Route::get('getTarifasComparadorCuotaMensual/{lang?}', [TarifasController::class, 'getTarifasComparadorCuotaMensualList']);
    /* seguros salud */
    Route::get('getTarifasSegurosSalud/{lang?}/{categoria?}', [TarifasController::class, 'getTarifasSeguroSaludList']);
    Route::get('getTarifasComparadorSegurosSalud/{lang?}', [TarifasController::class, 'getTarifasComparadorSaludList']);
    Route::get('getDetailOffercomparadortarifassegurossalud/{id}', [TarifasController::class, 'getDetailOfferSaludList']);
    /* Streaming */
    Route::get('getTarifasStreaming/{lang?}', [TarifasController::class, 'getTarifasStreamingList']);
    /* blog */
    Route::get('getBlog/{lang?}', [BlogController::class, 'getBlogNewList']);
    Route::get('getBlog/{lang?}/{categoria?}/{amigable?}', [BlogController::class, 'getBlogItemList']);
    Route::get('getBlogHome/{lang?}', [BlogController::class, 'getBlogInfoHomeList']);
    Route::get('getMenuBlog/{lang?}', [BlogController::class, 'getMenuInfoBlogList']);
    /* Suministros */
    Route::get('getSuministros/{lang?}', [BlogController::class, 'getSuministrosList']);
    Route::get('getSuministrosById/{id}', [BlogController::class, 'getSuministrosList']);
    /* Seguros */
    /* Route::get('getSeguros/{lang?}', [BlogController::class, 'getSegurosList']);
    Route::get('getSegurosById/{id}', [BlogController::class, 'getSegurosList']); */
    /* Cobertura movil */
    Route::get('getCoberturaMovil/{lang?}', [BlogController::class, 'getCoberturaMovilList']);
    Route::get('getCoberturaMovilById/{id}', [BlogController::class, 'getCoberturaMovilList']);
    /* Cobertura fibra */
    Route::get('getCoberturaFibra/{lang?}', [BlogController::class, 'getCoberturaFibraList']);
    Route::get('getCoberturaFibraById/{id}', [BlogController::class, 'getCoberturaFibraList']);
    /* Obtener data de localizacion por Ip */
    Route::get('getDataLocation', [UtilsController::class, 'checkingGuestLocationApi']);
    Route::get('getDataIp', [UtilsController::class, 'obtencionIpRealVisitante']);
    /* Leads */
    Route::post('LeadRegister', [LeadController::class, 'LeadRegisterInfo']);
    Route::post('contactanosRegister', [LeadController::class, 'FormContactanosRegister']);
    Route::post('NewsletterRegister', [LeadController::class, 'FormNewsletterRegister']);
    Route::get('emailConfirmacion/{token}', [UtilsController::class, 'getEmailconfirmation']);
    /* Zapier */
    Route::post('facebookZapierCpl', [LeadController::class, 'LeadRegisterInfo']);
    /* registrar error en plataforma */
    Route::post('addError', [UtilsController::class, 'addError']);

    /* Mexico */
    Route::get('getTarifasPlanCelular/{lang?}', [TarifasController::class, 'getTarifasPlanCelularList']);
    Route::get('getfilterPlanCelular/{lang?}', [FilterController::class, 'getValuesFilterPlanCelularList']);
    Route::get('getExtraOffercomparadorPlanCelular/{lang?}', [ExtraOfferController::class, 'getExtraOfferPlanCelularList']);
    Route::get('getDetailOffercomparadorplanescelular/{id}', [TarifasController::class, 'getDetailOfferPlanCelularList']);

    /* Vehiculos */
    Route::get('getTarifasVehiculos/{lang?}', [TarifasController::class, 'getTarifasVehiculosList']);
    Route::get('getfilterVehiculos/{lang?}', [FilterController::class, 'getValuesFilterVehiculosList']);
    Route::get('getValuesFilterVehiculosChassis/{lang?}', [FilterController::class, 'getValuesFilterVehiculosChassisList']);
    Route::get('getExtraOffercomparadorVehiculos/{lang?}', [ExtraOfferController::class, 'getExtraOfferVehiculosList']);
    Route::get('getDetailOffervehiculos/{id}', [TarifasController::class, 'getDetailOfferVehiculosList']);
    /* Cupones */
    Route::get('getTarifasCupones/{lang?}/{categoria?}', [TarifasController::class, 'getTarifasCuponesList']);
    Route::get('getTarifasCuponesDestacados/{lang?}', [TarifasController::class, 'getTarifasCuponesDestacadosList']);
    Route::get('getTarifaCupon/{id}', [TarifasController::class, 'getTarifaCuponList']);
    Route::get('getPaisesCupon', [CuponesController::class, 'getPaisesCuponList']);
    Route::get('getCuponesComercio/{id}', [CuponesController::class, 'getCuponesComercioList']);
    Route::get('/getInformacionMarca/{id?}', [ApiController::class, 'cargarPaisesCupones']);
    Route::get('/getInformacionBuscadorCupon/{filtro?}', [ApiController::class, 'buscadorCuponesFiltro']);
    /* Route::get('/cargarCategoriaMarca/{id?}', [ApiController::class, 'cargarCategoriaMarca']); */
    Route::get('/getCategoriasPaises/{lang?}', [ApiController::class, 'cargarCategoriasPaisesCupones']);

    /* Prestamos */
    Route::get('getTarifasPrestamos/{lang?}/{categoria?}', [TarifasController::class, 'getTarifasPrestamosList']);
    Route::get('getBancasPrestamos/{lang?}/{categoria?}', [TarifasController::class, 'getBancasPrestamosList']);
    Route::get('getTarifaPrestamo/{id}', [TarifasController::class, 'getTarifaPrestamoList']);


    /* Prestamos */
    Route::get('getTarifasPrestamos/{lang?}/{categoria?}', [TarifasController::class, 'getTarifasPrestamosList']);
    Route::get('getBancasPrestamos/{lang?}/{categoria?}', [TarifasController::class, 'getBancasPrestamosList']);
    Route::get('getTarifaPrestamo/{id}', [TarifasController::class, 'getTarifaPrestamoList']);
    Route::get('getDetailOffercomparadorfinanzas/{id}', [TarifasController::class, 'getDetailOfferFinanzasList']);

    /* Administracion pagina web */
    /* Menu */
    /* Route::get('getMenu/{lang?}', [ApiController::class, 'getMenuList']); */
    Route::get('getMenuApi/{lang?}', [ApiController::class, 'getMenuApi']);
    /* carga footer */
    Route::get('getFooter/{lang?}', [ApiController::class, 'getFooterList']);


    /* mail */
    route::get('/cambioNombreIdComerciosCupones', function () {
        $data = Cupones::limit(200)->orderBy('store', 'desc')->get();
        foreach ($data as $item) {
            $a = Comercios::where('nombre', $item->store)->count();
            if ($a == 1) {
                $a = Comercios::where('nombre', $item->store)->first();
                $item['store'] = $a->id;
                $cupon = Cupones::find($item->id);
                if ($cupon->update(['store' => $a->id])) {
                    echo 'cambio de ' . $a->nombre . ' a ' . $a->id . ' realizado<br>';
                } else {
                    echo $a->id . ' no realizado<br>';
                }
            }
        }
    });
});
