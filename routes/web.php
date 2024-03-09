<?php

use App\Http\Controllers\ComercializadorasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperadorasController;
use App\Http\Controllers\ParillaFibraController;
use App\Http\Controllers\ParillaFibraMovilController;
use App\Http\Controllers\ParillaFibraMovilTvController;
use App\Http\Controllers\ParillaGasController;
use App\Http\Controllers\ParillaLuzController;
use App\Http\Controllers\ParillaLuzGasController;
use App\Http\Controllers\ParillaMovilController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\ParillaFibraMovil;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->middleware(['auth']);
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth']);
Route::resource('usuarios', UserController::class)->middleware(['auth'])->names('user');
Route::resource('permisos', PermisosController::class)->names('permisos')->middleware(['auth']);
Route::resource('roles', RolesController::class)->names('roles')->middleware(['auth']);
Route::resource('comercializadoras', ComercializadorasController::class)->names('comercializadoras')->middleware(['auth']);
Route::resource('operadoras', OperadorasController::class)->names('operadoras')->middleware(['auth']);
/* Telefonia */
Route::resource('parrillamovil', ParillaMovilController::class)->names('parrillamovil')->middleware(['auth']);
Route::resource('parrillafibra', ParillaFibraController::class)->names('parrillafibra')->middleware(['auth']);
Route::resource('parrillafibramovil', ParillaFibraMovilController::class)->names('parrillafibramovil')->middleware(['auth']);
Route::resource('parrillafibramoviltv', ParillaFibraMovilTvController::class)->names('parrillafibramoviltv')->middleware(['auth']);
/* energia */
Route::resource('parrillaluz', ParillaLuzController::class)->names('parrillaluz')->middleware(['auth']);
Route::resource('parrillagas', ParillaGasController::class)->names('parrillagas')->middleware(['auth']);
Route::resource('parrillaluzgas', ParillaLuzGasController::class)->names('parrillaluzgas')->middleware(['auth']);

