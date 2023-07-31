<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\IngresoMatricula;
use App\Models\IngresoVarios;
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
        $pdf->setPaper(array(0, 0, 226.772, 350.394), 'defaultPaperSize');

        return $pdf->stream('recibo_curso.pdf');
    }

    public function recibo_vario_insumo(IngresoVarios $ingresoVarios)
    {
        $pdf = PDF::loadView('pdf.ingreso_varios.recibo_insumo', compact('ingresoVarios'));
        // $pdf->setPaper(array(0, 0, 226.772, 350.394), 'defaultPaperSize');
        $pdf->setPaper(array(0, 0, 200.772, 400.394), 'defaultPaperSize');

        return $pdf->stream('recibo_vario.pdf');
    }
}
