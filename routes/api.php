<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstatusController;
use App\Http\Controllers\IglesiaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('usuarios/login', [UserController::class, "login"])->name('usuarios.login');

Route::group(['middleware' => ['auth:sanctum']], function(){
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

    Route::resource('categorias', CategoriaController::class)->except('show')->names('categorias');

    Route::resource('actividades', ActividadController::class)->except('show')->names('actividades');

    Route::resource('asistencias', AsistenciaController::class)->except('show')->names('asistencias');

    Route::resource('posts', PostController::class)->except('show','update')->names('posts');
    Route::post('posts/{id}', [PostController::class, "update"])->name('posts.update');
    Route::delete('eliminar_imagen/{id}', [PostController::class, "destroy_imagen_post"])->name('imagen.delete');
    Route::delete('eliminar_video/{id}', [PostController::class, "destroy_video_post"])->name('video.delete');
    Route::delete('eliminar_actividad/{id}', [PostController::class, "destroy_actividad_post"])->name('actividad.delete');

    Route::resource('comentario', ComentarioController::class)->except('index','show')->names('comentarios');

    Route::resource('videos', VideoController::class)->except('show')->names('videos');

    Route::get('logout', [UserController::class, "logout"])->name('logout');
});




