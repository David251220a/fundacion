<?php

namespace App\Http\Controllers;

use App\Models\CierreCaja;
use App\Models\Curso;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\IngresoMatricula;
use App\Models\IngresoVarios;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\SalarioInstructor;
use App\Models\TipoCurso;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function ingreso_curso_detallado($id, Request $request)
    {
        if($id == 1){
            $fecha = date('Y-m-d', strtotime($request->fecha_actual));
            $fecha_hasta = date('Y-m-d', strtotime($request->fecha_hasta));
            $data = IngresoMatricula::whereBetween('fecha_ingreso', [$fecha, $fecha_hasta])
            ->where('estado_id', 1)
            ->orderBy('fecha_ingreso', 'DESC')
            ->get();

            $titulo = 'Desde Fecha: ' . date('d/m/Y', strtotime($request->fecha_actual)) .
            ' Hasta Fecha: ' . date('d/m/Y', strtotime($request->fecha_hasta));
        }

        if($id == 2){
            $data = IngresoMatricula::where('numero_recibo', $request->recibo)
            ->where('estado_id', 1)
            ->get();

            $titulo = 'Por numero de recibo: ' . $request->recibo;

        }

        if($id == 3){
            $data = IngresoMatricula::where('numero_recibo', $request->recibo)
            ->where('estado_id', 1)
            ->take(30)
            ->get();

            $titulo = 'Por documento: ' . $request->documento;
        }

        if($id == 4){
            $fecha = date('Y-m-d', strtotime($request->fecha_actual));
            $fecha_hasta = date('Y-m-d', strtotime($request->fecha_hasta));
            $data = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
            ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
            ->select('ingreso_matriculas.*')
            ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
            ->where('ingreso_matriculas.estado_id', 1)
            ->where('b.tipo_curso_id', $request->aux_familia_id)
            ->orderBy('ingreso_matriculas.created_at', 'DESC')
            ->get();

            $familia = TipoCurso::find($request->aux_familia_id);

            $titulo = 'Por Familia: ' . $familia->descripcion;
        }

        if($id == 5){
            $fecha = date('Y-m-d', strtotime($request->fecha_actual));
            $fecha_hasta = date('Y-m-d', strtotime($request->fecha_hasta));
            $data = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
            ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
            ->select('ingreso_matriculas.*')
            ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
            ->where('ingreso_matriculas.estado_id', 1)
            ->where('b.curso_id', $request->aux_curso_id)
            ->orderBy('ingreso_matriculas.created_at', 'DESC')
            ->get();

            $curso = Curso::find($request->aux_familia_id);

            $titulo = 'Por Curso: ' . $curso->descripcion;
        }

        $pdf = PDF::loadView('pdf.ingreso_curso.detallado', compact('data', 'titulo'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('ingreso_curso_detallado.pdf');
    }

    public function recibo_curso(IngresoMatricula $ingresoMatricula)
    {
        $pdf = PDF::loadView('pdf.ingreso_curso.recibo', compact('ingresoMatricula'));
        $pdf->setPaper(array(0, 0, 226.772, 370.394), 'defaultPaperSize');

        return $pdf->stream('recibo_curso.pdf');
    }

    public function recibo_vario_insumo(IngresoVarios $ingresoVarios)
    {
        $pdf = PDF::loadView('pdf.ingreso_varios.recibo_insumo', compact('ingresoVarios'));
        // $pdf->setPaper(array(0, 0, 226.772, 350.394), 'defaultPaperSize');
        $pdf->setPaper(array(0, 0, 200.772, 400.394), 'defaultPaperSize');

        return $pdf->stream('recibo_vario.pdf');
    }

    public function recibo_vario(IngresoVarios $ingresoVarios)
    {

        if($ingresoVarios->curso_ingreso_id == 0){
            $pdf = PDF::loadView('pdf.ingreso_varios.recibo', compact('ingresoVarios'));
        }else{
            $pdf = PDF::loadView('pdf.ingreso_varios.recibo_insumo', compact('ingresoVarios'));
        }

        // $pdf->setPaper(array(0, 0, 226.772, 350.394), 'defaultPaperSize');
        $pdf->setPaper(array(0, 0, 200.772, 400.394), 'defaultPaperSize');

        return $pdf->stream('recibo_vario.pdf');

    }

    public function ingreso_varios_reporte($id, Request $request)
    {
        $fecha_actual = date('Y-m-d', strtotime($request->fecha_actual));
        $fecha_hasta = date('Y-m-d', strtotime($request->fecha_hasta));

        switch ($id) {
            case 1:
                $data = IngresoVarios::where('estado_id', 1)
                ->whereBetween('fecha_ingreso', [$fecha_actual, $fecha_hasta])
                ->orderBy('id', 'DESC')
                ->get();

                $titulo = 'Desde Fecha: ' . date('d/m/Y', strtotime($request->fecha_actual)) .
                ' Hasta Fecha: ' . date('d/m/Y', strtotime($request->fecha_hasta));

                break;

            case 2:
                $data = IngresoVarios::where('numero_recibo', $request->recibo)
                ->where('estado_id', 1)
                ->orderBy('id', 'DESC')
                ->get();
                $titulo = 'Por numero de recibo: ' . $request->recibo;
                break;

            case 3:
                $documento = str_replace('.', '', $request->documento);
                $persona = Persona::where('documento', $documento)->first();

                if(empty($persona)){
                    $persona_id = null;
                }else{
                    $persona_id = $persona->id;
                }

                $data = IngresoVarios::where('persona_id', $persona_id)
                ->whereBetween('fecha_ingreso', [$fecha_actual, $fecha_hasta])
                ->where('estado_id', 1)
                ->orderBy('id', 'DESC')
                ->get();
                $titulo = 'Por documento: ' . $request->documento;
                break;

            case 4:
                $data = IngresoVarios::where('estado_id', 1)
                ->whereBetween('fecha_ingreso', [$fecha_actual, $fecha_hasta])
                ->where('tipo_curso_id', $request->aux_familia_id)
                ->orderBy('id', 'DESC')
                ->get();

                $familia = TipoCurso::find($request->aux_familia_id);
                $titulo = 'Por Familia: ' . $familia->descripcion;
                break;
            case 5:
                $data = IngresoVarios::where('estado_id', 1)
                ->whereBetween('fecha_ingreso', [$fecha_actual, $fecha_hasta])
                ->where('curso_id', $request->aux_curso_id)
                ->orderBy('id', 'DESC')
                ->get();

                $curso = Curso::find($request->aux_familia_id);
                $titulo = 'Por Curso: ' . $curso->descripcion;
                break;

        }

        $pdf = PDF::loadView('pdf.ingreso_varios.detallado', compact('data', 'titulo'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('ingreso_varios_detallado.pdf');
    }

    public function recibo_anticipo_instructor($id)
    {
        $data = Pago::find($id);
        $pdf = PDF::loadView('pdf.salario.recibo_anticipo_instructor', compact('data'));
        $pdf->setPaper(array(0, 0, 200.772, 400.394), 'defaultPaperSize');

        return $pdf->stream('recibo_anticipo_instructor.pdf');

    }

    public function recibo_salario_instructor($id)
    {
        $data = Pago::find($id);
        $curso = $data->pago_instructor[0];
        $salario = SalarioInstructor::where('curso_habilitado_id', $curso->curso_habilitado_id)
        ->where('instructor_id', $curso->instructor_id)
        ->where('estado_id', 1)
        ->get();
        $pdf = PDF::loadView('pdf.salario.recibo_salario_instructor', compact('data', 'salario'));
        $pdf->setPaper(array(0, 0, 200.772, 470.394), 'defaultPaperSize');

        return $pdf->stream('recibo_salario_instructor.pdf');

    }

    public function recibo_anticipo_empleado($id)
    {
        $data = Pago::find($id);
        $pdf = PDF::loadView('pdf.salario.recibo_anticipo_empleado', compact('data'));
        $pdf->setPaper(array(0, 0, 200.772, 400.394), 'defaultPaperSize');

        return $pdf->stream('recibo_anticipo_empleado.pdf');
    }

    public function recibo_pago_varios($id)
    {
        $data = Pago::find($id);
        $pdf = PDF::loadView('pdf.salario.recibo_pago_varios', compact('data'));
        $pdf->setPaper(array(0, 0, 200.772, 360.394), 'defaultPaperSize');

        return $pdf->stream('recibo_pago_varios.pdf');
    }

    public function cierre_cajero(CierreCaja $cierreCaja)
    {
        $pdf = PDF::loadView('pdf.cierre.cajero', compact('cierreCaja'));
        return $pdf->stream('cierre_caja.pdf');
    }


    public function lista_aprobado(CursoHabilitado $cursoHabilitado)
    {

        $alumnos = CursoAlumno::where('curso_habilitado_id', $cursoHabilitado->id)
        ->where('curso_a_estado_id', 3)
        ->where('estado_id', 1)
        ->where('aprobado', 1)
        ->get();

        $pdf = PDF::loadView('pdf.curso.lista_aprobado', compact('alumnos', 'cursoHabilitado'));

        return $pdf->stream('lista_aprobado.pdf');
    }

}
