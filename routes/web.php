<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HabilitarCursoController;
use App\Http\Controllers\Limpiar;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\TipoCursoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\GrupoUsuarioController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [InicioController::class, 'inicio'])->name('inicio');
Route::get('/nosotros', [InicioController::class, 'nosotros'])->name('nosotros');
Route::get('/cursos', [InicioController::class, 'cursos'])->name('cursos');
Route::get('/contacto', [InicioController::class, 'contacto'])->name('contacto');
Route::get('/new', [InicioController::class, 'new'])->name('new');
Route::get('/new/{slug}', [InicioController::class, 'new_detalle'])->name('new_detalle');

Route::get('/limpiar', [Limpiar::class, 'limpiar'])->name('limpiar');
Route::get('/crear/acceso', [Limpiar::class, 'acceso'])->name('acceso');

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::group([
    'middleware' => 'auth',
], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/noticia', NoticiasController::class, ['parameters' => [
        'noticia' => 'noticia',
    ],
    ])->names('noticias');
    Route::get('/tipocurso', [TipoCursoController::class, 'index'])->name('tipocurso.index');
    Route::resource('/admin/cursos', CursoController::class)->names('curso');
    Route::resource('/users', UsuarioController::class)->names('user');
    Route::resource('/roles', GrupoUsuarioController::class)->names('role');
    Route::resource('/curso/habilitado/', HabilitarCursoController::class, ['parameters' => [
        'cursoHabilitado' => 'cursoHabilitado',
    ],
    ])->names('habilitado');
    Route::resource('/instructor' ,InstructorController::class)->names('instructor');

});

