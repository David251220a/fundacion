<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Limpiar;
use App\Http\Controllers\NoticiasController;
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

Route::get('/limpiar', [Limpiar::class, 'limpiar'])->name('limpiar');
Route::get('/crear/acceso', [Limpiar::class, 'acceso'])->name('acceso');

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::group([
    'middleware' => 'auth',
], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/noticia', NoticiasController::class)->names('noticias');

});

