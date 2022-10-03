<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstadoCivilController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\RangoController;
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

Route::resource('iglesias', IglesiaController::class)->except('show','index','create','edit')->names('iglesias');
Route::resource('equipos', EquipoController::class)->except('show','index','create','edit')->names('equipos');
Route::resource('rangos', RangoController::class)->except('show','index','create','edit')->names('rangos');
Route::resource('estadosciviles', EstadoCivilController::class)->except('show','index','create','edit')->names('estadosciviles');

