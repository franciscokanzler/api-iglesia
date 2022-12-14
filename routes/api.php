<?php

use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstatusController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::resource('organismos', OrganismoController::class)->except('show')->names('organismos'); */

Route::resource('iglesias', IglesiaController::class)->except('show','create')->names('iglesias');

Route::resource('usuarios', UserController::class)->names('usuarios');

Route::resource('equipos', EquipoController::class)->except('show')->names('equipos');
Route::get('miembrosequipos/{id}', [EquipoController::class, "index_equipo_miembro"])->name('miembrosequipos');
Route::post('miembrosequipos/create', [EquipoController::class, "create_equipo_miembro"])->name('miembrosequipos.create');
Route::post('miembrosequipos', [EquipoController::class, "store_equipo_miembro"])->name('miembrosequipos.store');
Route::delete('miembrosequipos/{equipo}/{miembro}', [EquipoController::class, "destroy_equipo_miembro"])->name('miembrosequipos.delete');

Route::resource('rangos', RangoController::class)->except('show','create')->names('rangos');
Route::resource('ciudadanos', CiudadanoController::class)->except('show','create')->names('ciudadanos');

Route::resource('miembros', MiembroController::class)->except('show')->names('miembros');
Route::get('municipios/{id}', [MiembroController::class, "municipios"])->name('municipios');
Route::get('parroquias/{id}', [MiembroController::class, "parroquias"])->name('parroquias');

Route::resource('roles', RoleController::class)->except('show')->names('roles');

Route::resource('estatus', EstatusController::class)->except('show')->names('estatus');
