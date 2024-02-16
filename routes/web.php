<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::resource('permisos', PermisosController::class)->names('permisos');

Route::resource('roles', RolesController::class)->names('roles');

