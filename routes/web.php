<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CursoAlumnoController;
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
    Route::resource('/habilitacion', HabilitarCursoController::class, ['parameters' => [
        'habilitacion' => 'cursoHabilitado',
    ],
    ])->names('habilitado');

    Route::get('/curso/alumno/{cursoHabilitado}', [CursoAlumnoController::class, 'buscar'])->name('cursoAlumno.buscar');
    Route::post('/curso/alumno/{cursoHabilitado}', [CursoAlumnoController::class, 'buscar_post'])->name('cursoAlumno.buscar_post');
    Route::get('/curso/alumno/{cursoHabilitado}/agregar/{alumno}', [CursoAlumnoController::class, 'agregar_alumno'])->name('cursoAlumno.agregar_alumno');
    Route::post('/curso/alumno/{cursoHabilitado}/agregar/{alumno}', [CursoAlumnoController::class, 'agregar_alumno_post'])->name('cursoAlumno.agregar_alumno_post');
    Route::get('/curso/alumno/{cursoHabilitado}/crear', [CursoAlumnoController::class, 'crear_alumno'])->name('cursoAlumno.crear_alumno');
    Route::post('/curso/alumno/{cursoHabilitado}/crear', [CursoAlumnoController::class, 'crear_alumno_post'])->name('cursoAlumno.crear_alumno_post');
    Route::get('/curso/alumno/{cursoHabilitado}/asistencia', [CursoAlumnoController::class, 'asistencia'])->name('cursoAlumno.asistencia');
    Route::post('/curso/alumno/{cursoHabilitado}/asistencia', [CursoAlumnoController::class, 'asistencia_post'])->name('cursoAlumno.asistencia_post');

    Route::resource('/instructor' ,InstructorController::class)->names('instructor');
    Route::get('/instructor/add/nuevo/{persona}' , [InstructorController::class, 'add_nuevo'])->name('instructor.add_nuevo');
    Route::post('/instructor/add/nuevo/{persona}' , [InstructorController::class, 'add_nuevo_post'])->name('instructor.add_nuevo_post');

    Route::resource('/alumno' , AlumnoController::class)->names('alumno');
    Route::get('/alumno/add/nuevo/{persona}' , [AlumnoController::class, 'add_nuevo'])->name('alumno.add_nuevo');
    Route::post('/alumno/add/nuevo/{persona}' , [AlumnoController::class, 'add_nuevo_post'])->name('alumno.add_nuevo_post');

    Route::get('/validar/alumno/',[AlumnoController::class, 'validar'])->name('alumno.validar');
    Route::post('/validar/alumno/',[AlumnoController::class, 'validar_post'])->name('alumno.validar_post');
    Route::get('/validar/instructor/',[InstructorController::class, 'validar'])->name('instructor.validar');
    Route::post('/validar/instructor/',[InstructorController::class, 'validar_post'])->name('instructor.validar_post');

});

