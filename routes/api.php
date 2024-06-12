<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExtraOfferController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\TarifasController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\ZapierController;

Route::get('/', function(){
    return 'welcome to Vuskoo!';
});

Route::get('getOperadoras', [ApiController::class, 'getOperadorasMovilList']);
Route::get('getComercializadorasLuz', [ApiController::class, 'getComercializadorasLuzList']);
Route::get('getComercializadorasGas', [ApiController::class, 'getComercializadorasGasList']);
Route::get('getOperadorasFibra', [ApiController::class, 'getOperadorasFibraList']);
Route::get('getOperadorasPlanCelular', [ApiController::class, 'getOperadorasPlanCelularList']);
Route::get('getComercializadorasLuzGas', [ApiController::class, 'getComercializadorasLuzGasList']);
Route::get('getOperadorasFibraMovil', [ApiController::class, 'getOperadorasFibraMovilList']);
Route::get('getOperadorasFibraMovilTv', [ApiController::class, 'getOperadorasFibraMovilTvList']);
Route::get('getMarcasVehiculos', [ApiController::class, 'getMarcasVehiculosList']);
Route::get('getComerciosCupones/{lang?}/{categoria?}', [ApiController::class, 'getComerciosCuponesList']);
Route::get('getTipoCupones/{lang?}/{categoria?}', [ApiController::class, 'getTipoCuponesList']);
/* Luz */
Route::get('getTarifasLuz', [TarifasController::class, 'getTarifasLuzList']);
Route::get('getExtraOfferluz', [ExtraOfferController::class, 'getExtraOfferLuzList']);
Route::get('getDetailOffercomparadortarifasluz/{id}', [TarifasController::class, 'getDetailOfferLuzList']);
/* Gas */
Route::get('getTarifasGas', [TarifasController::class, 'getTarifasGasList']);
Route::get('getExtraOffergas', [ExtraOfferController::class, 'getExtraOfferGasList']);
Route::get('getDetailOffercomparadortarifasgas/{id}', [TarifasController::class, 'getDetailOfferGasList']);
/* Luz y Gas */
Route::get('getTarifasGasLuz', [TarifasController::class, 'getTarifasGasLuzList']);
Route::get('getExtraOfferluzygas', [ExtraOfferController::class, 'getExtraOfferGasLuzList']);
Route::get('getDetailOffercomparadortarifasluzygas/{id}', [TarifasController::class, 'getDetailOfferGasLuzList']);
/* movil */
Route::get('getTarifasMovil', [TarifasController::class, 'getTarifasMovilList']);
Route::get('filterMovil', [FilterController::class, 'getValuesFilterMovilList']);
Route::get('getExtraOffercomparadormovil', [ExtraOfferController::class, 'getExtraOfferMovilList']);
Route::get('getDetailOffercomparadormovil/{id}', [TarifasController::class, 'getDetailOfferMovilList']);
/* Fibra */
Route::get('getTarifasFibra', [TarifasController::class, 'getTarifasFibraList']);
Route::get('filterFibra', [FilterController::class, 'getValuesFilterFibraList']);
Route::get('getExtraOffercomparadorfibra', [ExtraOfferController::class, 'getExtraOfferFibraList']);
Route::get('getDetailOffercomparadorfibra/{id}', [TarifasController::class, 'getDetailOfferFibraList']);
/* Fibra y Movil */
Route::get('getTarifasFibraMovil', [TarifasController::class, 'getTarifasFibraMovilList']);
Route::get('filterMovilFibra', [FilterController::class, 'getValuesFilterFibraMovilList']);
Route::get('getExtraOffercomparadortarifasfibraymovil', [ExtraOfferController::class, 'getExtraOfferFibraMovilList']);
Route::get('getDetailOffercomparadortarifasfibraymovil/{id}', [TarifasController::class, 'getDetailOfferFibraMovilList']);
/* Fibra, Movil y TV */
Route::get('getTarifasFibraMovilTv', [TarifasController::class, 'getTarifasFibraMovilTvList']);
Route::get('filterMovilFibraTv', [FilterController::class, 'getValuesFilterFibraMovilTvList']);
Route::get('getExtraOffercomparadormovilfibratv', [ExtraOfferController::class, 'getExtraOfferFibraMovilTvList']);
Route::get('getDetailOffercomparadorfibramoviltv/{id}', [TarifasController::class, 'getDetailOfferFibraMovilTvList']);
/* Streaming */
Route::get('getTarifasStreaming', [TarifasController::class, 'getTarifasStreamingList']);
/* blog */
Route::get('getBlog', [BlogController::class, 'getBlogList']);
Route::get('getBlogPreview/{id}', [BlogController::class, 'getBlogPreviewList']);
Route::get('getBlogHome', [BlogController::class, 'getBlogHomeList']);
Route::get('getBlog/{categoria}/{id?}', [BlogController::class, 'getBlogList']);
Route::get('getMenuBlog/{lang?}', [BlogController::class, 'getMenuBlogList']);
/* Suministros */
Route::get('getSuministros', [BlogController::class, 'getSuministrosList']);
Route::get('getSuministrosById/{id}', [BlogController::class, 'getSuministrosList']);
/* Seguros */
Route::get('getSeguros', [BlogController::class, 'getSegurosList']);
Route::get('getSegurosById/{id}', [BlogController::class, 'getSegurosList']);
/* Cobertura movil */
Route::get('getCoberturaMovil', [BlogController::class, 'getCoberturaMovilList']);
Route::get('getCoberturaMovilById/{id}', [BlogController::class, 'getCoberturaMovilList']);
/* Cobertura fibra */
Route::get('getCoberturaFibra', [BlogController::class, 'getCoberturaFibraList']);
Route::get('getCoberturaFibraById/{id}', [BlogController::class, 'getCoberturaFibraList']);
/* optimizacion */
Route::get('getGestion/{funcion}/{id?}', [BlogController::class, 'getGestionList']);
/* Obtener data de localizacion por Ip */
Route::get('getDataLocation', [UtilsController::class, 'checkingGuestLocationApi']);
Route::get('getDataIp', [UtilsController::class, 'obtencionIpRealVisitante']);
/* Leads */
Route::post('LeadRegister', [LeadController::class, 'LeadRegisterInfo']);
Route::post('contactanosRegister', [LeadController::class, 'FormContactanosRegister']);
Route::post('NewsletterRegister', [LeadController::class, 'FormNewsletterRegister']);

/* Zapier */
Route::post('facebookZapierCpl', [ZapierController::class, 'facebookZapierCpl']);
Route::post('redesSocialesZapier', [ZapierController::class, 'redesSocialesZapier']);
Route::post('redesSocialesEnergyZapier', [ZapierController::class, 'redesSocialesEnergyZapier']);

/* Menu */
Route::get('getMenu/{lang?}', [ApiController::class, 'getMenuList']);

/* Mexico */
Route::get('getTarifasPlanCelular', [TarifasController::class, 'getTarifasPlanCelularList']);
Route::get('filterPlanCelular', [FilterController::class, 'getValuesFilterPlanCelularList']);
Route::get('getExtraOffercomparadorPlanCelular', [ExtraOfferController::class, 'getExtraOfferPlanCelularList']);
Route::get('getDetailOffercomparadorplanescelular/{id}', [TarifasController::class, 'getDetailOfferPlanCelularList']);

/* Vehiculos */
Route::get('getTarifasVehiculos', [TarifasController::class, 'getTarifasVehiculosList']);
Route::get('filterVehiculos', [FilterController::class, 'getValuesFilterVehiculosList']);
Route::get('getValuesFilterVehiculosChassis', [FilterController::class, 'getValuesFilterVehiculosChassisList']);
Route::get('getExtraOffercomparadorVehiculos', [ExtraOfferController::class, 'getExtraOfferVehiculosList']);
Route::get('getDetailOffervehiculos/{id}', [TarifasController::class, 'getDetailOfferVehiculosList']);

/* Cupones */
Route::get('getTarifasCupones/{lang?}/{categoria?}', [TarifasController::class, 'getTarifasCuponesList']);
Route::get('getTarifaCupon/{id}', [TarifasController::class, 'getTarifaCuponList']);
Route::get('filterCupones', [FilterController::class, 'getValuesFilterCuponesList']);
Route::get('getExtraOffercomparadorCupones', [ExtraOfferController::class, 'getExtraOfferCuponesList']);
Route::get('getDetailOfferCupones/{id}', [TarifasController::class, 'getDetailOfferCuponesList']);
/*  */
Route::get('/cargarPaises/{id?}', [ApiController::class, 'cargarPaisesCupones']);
Route::get('/cargarCategoriasPaises/{id?}', [ApiController::class, 'cargarCategoriasPaisesCupones']);

/* Prestamos */
Route::get('getTarifasPrestamos/{lang?}', [TarifasController::class, 'getTarifasPrestamosList']);
Route::get('getTarifaPrestamo/{id}', [TarifasController::class, 'getTarifaPrestamoList']);