<?php

use App\Http\Controllers\ComercializadorasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperadorasController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'index'])->middleware(['auth']);
Route::resource('usuarios', UserController::class)->names('user')->middleware(['auth']);
Route::resource('permisos', PermisosController::class)->names('permisos')->middleware(['auth']);
Route::resource('roles', RolesController::class)->names('roles')->middleware(['auth']);
Route::resource('comercializadoras', ComercializadorasController::class)->names('comercializadoras')->middleware(['auth']);
Route::resource('operadoras', OperadorasController::class)->names('operadoras')->middleware(['auth']);

