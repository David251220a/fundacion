<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConsultaGeneralController;
use App\Http\Controllers\CursoAlumnoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HabilitarCursoController;
use App\Http\Controllers\Limpiar;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\TipoCursoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\GrupoUsuarioController;
use App\Http\Controllers\IngresoMatriculaController;
use App\Http\Controllers\IngresoVarioController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PagoEmpleadoController;
use App\Http\Controllers\PagoInstructorController;
use App\Http\Controllers\PagoVariosController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfesorController;
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
    Route::get('/habilitacion/{cursoHabilitado}/califar', [HabilitarCursoController::class, 'calificar'])->name('habilitado.calificar');
    Route::post('/habilitacion/{cursoHabilitado}/califar', [HabilitarCursoController::class, 'calificar_post'])->name('habilitado.calificar_post');

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

    Route::get('/ingreso/matricula', [IngresoMatriculaController::class, 'index'])->name('ingreso_matricula.index');
    Route::get('/ingreso/curso/{alumno}/cobro', [IngresoMatriculaController::class, 'cobro_curso'])->name('ingreso_matricula.cobro_alumno');

    Route::get('/validar/alumno/',[AlumnoController::class, 'validar'])->name('alumno.validar');
    Route::post('/validar/alumno/',[AlumnoController::class, 'validar_post'])->name('alumno.validar_post');
    Route::get('/validar/instructor/',[InstructorController::class, 'validar'])->name('instructor.validar');
    Route::post('/validar/instructor/',[InstructorController::class, 'validar_post'])->name('instructor.validar_post');

    Route::get('ingreso/varios', [IngresoVarioController::class, 'index'])->name('ingreso_varios.index');
    Route::get('ingreso/varios/consulta', [IngresoVarioController::class, 'consulta'])->name('ingreso_varios.consulta');
    Route::get('ingreso/varios/buscar/{id}', [IngresoVarioController::class, 'buscar'])->name('ingreso_varios.buscar');
    Route::post('ingreso/varios/buscar/{id}', [IngresoVarioController::class, 'buscar_post'])->name('ingreso_varios.buscar_post');
    Route::get('ingreso/varios/{persona}/ingreso', [IngresoVarioController::class, 'ingreso_persona'])->name('ingreso_varios.ingreso_persona');
    Route::post('ingreso/varios/{persona}/ingreso', [IngresoVarioController::class, 'ingreso_persona_post'])->name('ingreso_varios.ingreso_persona_post');
    Route::post('ingreso/crear_ingreso_concepto', [IngresoVarioController::class, 'crear_ingreso_concepto'])->name('ingreso_varios.crear_ingreso_concepto');
    Route::get('ingreso/recibo/{ingreso}', [IngresoVarioController::class, 'ver_recibo'])->name('ingreso_varios.ver_recibo');
    Route::get('ingreso/varios/{persona}/ingreso/pendiente', [IngresoVarioController::class, 'ingreso_pendiente'])->name('ingreso_varios.ingreso_pendiente');
    Route::post('ingreso/varios/{persona}/ingreso/pendiente', [IngresoVarioController::class, 'ingreso_pendiente_post'])->name('ingreso_varios.ingreso_pendiente_post');

    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/{tipoCurso}/show', [AgendaController::class, 'show'])->name('agenda.show');
    Route::get('/agenda/{curso}/agendar', [AgendaController::class, 'agenda'])->name('agenda.agenda');
    Route::get('/agenda/{curso}/habilitar', [AgendaController::class, 'habilitar'])->name('agenda.habilitar');
    Route::post('/agenda/{curso}/habilitar', [AgendaController::class, 'habilitar_post'])->name('agenda.habilitar_post');
    Route::get('/agenda/general', [AgendaController::class, 'general'])->name('agenda.general');


    Route::get('/profesor', [ProfesorController::class, 'index'])->name('profesor.index');
    Route::get('/profesor/{cursoHabilitado}', [ProfesorController::class, 'show'])->name('profesor.show');
    Route::get('/profesor/{cursoHabilitado}/asistencia', [ProfesorController::class, 'asistencia'])->name('profesor.asistencia');
    Route::post('/profesor/{cursoHabilitado}/asistencia', [ProfesorController::class, 'asistencia_post'])->name('profesor.asistencia_post');
    Route::get('/profesor/{cursoHabilitado}/calificar', [ProfesorController::class, 'calificar'])->name('profesor.calificar');
    Route::post('/profesor/{cursoHabilitado}/calificar', [ProfesorController::class, 'calificar_post'])->name('profesor.calificar_post');

    Route::get('/general', [GeneralController::class, 'index'])->name('general.index');

    Route::get('/pdf/ingreso-curso/detallado/{id}', [PDFController::class, 'ingreso_curso_detallado'])->name('ingreso_curso.detallado');
    Route::get('/pdf/ingreso-curso/{ingresoMatricula}/recibo', [PDFController::class, 'recibo_curso'])->name('ingreso_curso.recibo');
    Route::get('/pdf/ingreso-vario/{ingresoVarios}/insumo', [PDFController::class, 'recibo_vario_insumo'])->name('ingreso_vario.recibo_vario_insumo');
    Route::get('/pdf/ingreso-vario/{ingresoVarios}/recibo', [PDFController::class, 'recibo_vario'])->name('ingreso_vario.recibo_vario');
    Route::get('/pdf/ingreso-vario/{id}/reporte', [PDFController::class, 'ingreso_varios_reporte'])->name('ingreso_vario.ingreso_varios_reporte');
    Route::get('/pdf/pago-instructor/{id}/anticpo', [PDFController::class, 'recibo_anticipo_instructor'])->name('pdf.recibo_anticipo_instructor');
    Route::get('/pdf/pago-instructor/{id}/salario', [PDFController::class, 'recibo_salario_instructor'])->name('pdf.recibo_salario_instructor');
    Route::get('/pdf/pago-empleado/{id}/anticipo', [PDFController::class, 'recibo_anticipo_empleado'])->name('pdf.recibo_anticipo_empleado');
    Route::get('/pdf/pago/{id}/varios', [PDFController::class, 'recibo_pago_varios'])->name('pdf.recibo_pago_varios');


    Route::get('/pago/instructores', [PagoInstructorController::class, 'index'])->name('pago_instructor.index');
    Route::get('/pago/empleados', [PagoEmpleadoController::class, 'index'])->name('pago_empleados.index');
    Route::get('/pago/empleados/cierre', [PagoEmpleadoController::class, 'create'])->name('pago_empleados.create');
    Route::post('/pago/empleados/cierre', [PagoEmpleadoController::class, 'store'])->name('pago_empleados.store');
    Route::get('/pago/empleados/{pago}/ver', [PagoEmpleadoController::class, 'show'])->name('pago_empleados.show');
    Route::get('/pago/varios', [PagoVariosController::class, 'index'])->name('pago_varios.index');

    Route::get('/consulta/curso/deuda', [ConsultaGeneralController::class, 'curso_deuda'])->name('consulta.curso_deuda');



});

