<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\EstadoCivil;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\Partido;
use App\Models\Persona;
use App\Models\TipoFamilia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CursoAlumnoController extends Controller
{
    public function buscar(CursoHabilitado $cursoHabilitado)
    {
        return view('cursoAlumno.buscar', compact('cursoHabilitado'));
    }

    public function buscar_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'documento' => 'required',
        ]);

        $documento = str_replace('.', '', $request->documento);
        $persona = Persona::where('documento', $documento)->first();

        if(empty($persona)){
            return redirect()->route('cursoAlumno.crear_alumno', $cursoHabilitado);
        }else{
            if(empty($persona->alumno)){
                Alumno::create([
                    'persona_id' => $persona->id,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        $alumno = $persona->alumno;
        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno]);

    }

    public function crear_alumno(CursoHabilitado $cursoHabilitado)
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('cursoAlumno.create', compact('tipo_familia', 'partido', 'estado_civil', 'cursoHabilitado'));
    }

    public function crear_alumno_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento',
        ]);

        $persona = Persona::create([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'pais_id' => $request->pais_id,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'departamento_id' => $request->departamento_id,
            'ciudad_id' => $request->ciudad_id,
            'barrio_id' => $request->barrio_id,
            'estado_id' => $request->estado_id,
            'estado_civil_id' => $request->estado_civil_id,
            'partido_id' => $request->partido_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $nombre_familiar = $request->nombre_familiar;
        $apellido_familiar = $request->apellido_familiar;
        $tipo_familia = $request->tipo_familia;
        $partido = $request->partido;

        if($nombre_familiar)
        {
            for ($i=0; $i < count($nombre_familiar); $i++) {
                $persona->familiares()->create([
                    'nombre' => $nombre_familiar[$i],
                    'apellido' => $apellido_familiar[$i],
                    'tipo_familia_id' => $tipo_familia[$i],
                    'partido_id' => $partido[$i],
                    'estado_id' => $request->estado_id,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        $alumno = Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno])->with('message', 'Alumno inscrito con exito.');
    }

    public function agregar_alumno(CursoHabilitado $cursoHabilitado, Alumno $alumno)
    {
        $forma_pago = FormaPago::all();

        return view('cursoAlumno.inscribir', compact('cursoHabilitado', 'alumno', 'forma_pago'));
    }

    public function agregar_alumno_post(CursoHabilitado $cursoHabilitado, Alumno $alumno, Request $request)
    {
        $monto_abonado = ( empty($request->total_pagar) ? 0 : str_replace('.', '', $request->total_pagar));

        $cursoAlumno = CursoAlumno::create([
            'curso_habilitado_id' => $cursoHabilitado->id,
            'curso_a_estado_id' => 1,
            'alumno_id' => $alumno->id,
            'total_pagar' => $cursoHabilitado->precio,
            'monto_abonado' => $monto_abonado,
            'saldo' => ($cursoHabilitado->precio - $monto_abonado),
            'aprobado' => 0,
            'certificado' => '',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoMatricula::where('mes', $mes)
        ->where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo += 1;

        if($monto_abonado > 0){
            $ingreso = IngresoMatricula::create([
                'alumno_id' => $alumno->id,
                'fecha_ingreso' => $fecha_actual,
                'forma_pago_id' => $request->forma_pago_id,
                'año' => $anio,
                'mes' => $mes,
                'numero_recibo' => $numero_recibo,
                'sucursal' => '000',
                'general' => '000',
                'factura_numero' => 0,
                'total_pagado' => $monto_abonado,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $ingreso->detalle()->create([
                'curso_habilitado_id' => $cursoHabilitado->id,
                'alumno_id' => $alumno->id,
                'monto_total' => $cursoHabilitado->precio,
                'monto_pagado' => $monto_abonado,
                'saldo' => ($cursoHabilitado->precio - $monto_abonado),
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        return redirect()->route('habilitado.show', $cursoHabilitado)->with('message', 'Alumno inscrito con exito.');
    }
}
