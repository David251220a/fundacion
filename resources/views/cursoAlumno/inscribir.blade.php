@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2 class="">Cursos - Agregar Alumno </h2>
                </div>
            </div>
            
            @if ($curso->count() > 0)
                <div class="row mt-3">
                    <h4 class="mx-3">Deudas Pendiente en Cursos</h4>
                    <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="20%">IDCurso</th>
                                    <th width="20%">Curso</th>
                                    <th width="30%">Detalle Curso</th>
                                    <th>Concluido?</th>
                                    <th width="10%">Saldo</th>
                                    <th class="no-content">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($curso as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->curso_habilitado->id}} - {{$item->curso_habilitado->tipo_curso->descripcion}}: {{$item->curso_habilitado->curso->descripcion}}
                                            {{$item->curso_habilitado->curso->modulo->descripcion}}
                                        </td>
                                        <td>
                                            Horario: {{date('H:i', strtotime($item->curso_habilitado->hora_entrada))}} a {{date('H:i', strtotime($item->curso_habilitado->hora_salida))}}
                                            | Fecha: {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}} a {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}} <br>
                                            Dias: {{ ($item->curso_habilitado->lunes == 1 ? 'LUNES ' : '') }}
                                            {{ ($item->curso_habilitado->martes == 1 ? 'MARTES ' : '')}}
                                            {{ ($item->curso_habilitado->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                            {{ ($item->curso_habilitado->jueves == 1 ? 'JUEVES ' : '')}}
                                            {{ ($item->curso_habilitado->viernes == 1 ? 'VIERNES ' : '')}}
                                            {{ ($item->curso_habilitado->sabado == 1 ? 'SABADO ' : '')}}
                                            {{ ($item->curso_habilitado->domingo == 1 ? 'DOMINGO ' : '')}}
                                            | Precio: {{number_format($item->curso_habilitado->precio, 0, ".", ".")}}
                                        </td>
                                        <td>
                                            {{($item->curso_habilitado->concluido == 0 ? 'NO' : 'SI')}}
                                        </td>
                                        <td>
                                            {{number_format($item->saldo, 0, ".", ".")}}
                                        </td>
                                        <td>
                                            <a href="{{route('habilitado.show', $item->curso_habilitado->id)}}" target="__blank" class="btn btn-primary btn-sm">Ir al curso</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total Deuda Curso</th>
                                    <th colspan="2">{{number_format($curso->sum('saldo'), 0, ".", ".")}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>  
            @endif

            @if ($cert->count() > 0)
                <div class="row mt-3">
                    <h4 class="mx-3">Deudas Pendiente en Certificado</h4>
                    <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="20%">IDCurso</th>
                                    <th width="20%">Curso</th>
                                    <th width="30%">Detalle Curso</th>
                                    <th>Concluido?</th>
                                    <th width="10%">Saldo</th>
                                    <th class="no-content">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cert as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->curso_habilitado->id}} - {{$item->curso_habilitado->tipo_curso->descripcion}}: {{$item->curso_habilitado->curso->descripcion}}
                                            {{$item->curso_habilitado->curso->modulo->descripcion}}
                                        </td>
                                        <td>
                                            Horario: {{date('H:i', strtotime($item->curso_habilitado->hora_entrada))}} a {{date('H:i', strtotime($item->curso_habilitado->hora_salida))}}
                                            | Fecha: {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}} a {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}} <br>
                                            Dias: {{ ($item->curso_habilitado->lunes == 1 ? 'LUNES ' : '') }}
                                            {{ ($item->curso_habilitado->martes == 1 ? 'MARTES ' : '')}}
                                            {{ ($item->curso_habilitado->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                            {{ ($item->curso_habilitado->jueves == 1 ? 'JUEVES ' : '')}}
                                            {{ ($item->curso_habilitado->viernes == 1 ? 'VIERNES ' : '')}}
                                            {{ ($item->curso_habilitado->sabado == 1 ? 'SABADO ' : '')}}
                                            {{ ($item->curso_habilitado->domingo == 1 ? 'DOMINGO ' : '')}}
                                            | Precio: {{number_format($item->certificado_monto, 0, ".", ".")}}
                                        </td>
                                        <td>
                                            {{($item->curso_habilitado->concluido == 0 ? 'NO' : 'SI')}}
                                        </td>
                                        <td>
                                            {{number_format($item->certificado_saldo, 0, ".", ".")}}
                                        </td>
                                        <td>
                                            <a href="{{route('habilitado.show', $item->curso_habilitado->id)}}" target="__blank" class="btn btn-primary btn-sm">Ir al curso</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total Deuda Certificado</th>
                                    <th colspan="2">{{number_format($cert->sum('certificado_saldo'), 0, ".", ".")}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>  
            @endif
            
            @if ($insu->count() > 0)
                <div class="row mt-3">
                    <h4 class="mx-3">Deudas Pendiente en Insumos</h4>
                    <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="20%">IDCurso</th>
                                    <th width="20%">Curso</th>
                                    <th width="30%">Detalle Curso</th>
                                    <th>Concluido?</th>
                                    <th width="8%">Fecha Insumo</th>
                                    <th width="10%">Saldo</th>
                                    <th class="no-content">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insu as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->cursoHabilitado->id}} - {{$item->cursoHabilitado->tipo_curso->descripcion}}: {{$item->cursoHabilitado->curso->descripcion}}
                                            {{$item->cursoHabilitado->curso->modulo->descripcion}}
                                        </td>
                                        <td>
                                            Horario: {{date('H:i', strtotime($item->cursoHabilitado->hora_entrada))}} a {{date('H:i', strtotime($item->cursoHabilitado->hora_salida))}}
                                            | Fecha: {{date('d/m/Y', strtotime($item->cursoHabilitado->periodo_desde))}} a {{date('d/m/Y', strtotime($item->cursoHabilitado->periodo_hasta))}} <br>
                                            Dias: {{ ($item->cursoHabilitado->lunes == 1 ? 'LUNES ' : '') }}
                                            {{ ($item->cursoHabilitado->martes == 1 ? 'MARTES ' : '')}}
                                            {{ ($item->cursoHabilitado->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                            {{ ($item->cursoHabilitado->jueves == 1 ? 'JUEVES ' : '')}}
                                            {{ ($item->cursoHabilitado->viernes == 1 ? 'VIERNES ' : '')}}
                                            {{ ($item->cursoHabilitado->sabado == 1 ? 'SABADO ' : '')}}
                                            {{ ($item->cursoHabilitado->domingo == 1 ? 'DOMINGO ' : '')}}
                                            | Precio: {{number_format($item->cursoHabilitado->precio, 0, ".", ".")}}
                                    </td>
                                        <td>
                                            {{($item->cursoHabilitado->concluido == 0 ? 'NO' : 'SI')}}
                                        </td>
                                        <td class="text-center" style="font-size: 11px">
                                            {{date('d/m/Y', strtotime($item->fecha))}}
                                        </td>
                                        <td>
                                            {{number_format($item->saldo, 0, ".", ".")}}
                                        </td>
                                        <td>
                                            <a href="{{route('habilitado.show', $item->cursoHabilitado->id)}}" target="__blank" class="btn btn-primary btn-sm">Ir al curso</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total Deuda en Insumos</th>
                                    <th colspan="2">{{number_format($insu->sum('saldo'), 0, ".", ".")}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>  
            @endif
            

            <form action="{{route('cursoAlumno.agregar_alumno_post', [$cursoHabilitado, $alumno] )}}" method="POST" onsubmit="disableButton()">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="">Documento</label>
                        <input type="text" class="form-control w-full text-right" value="{{number_format($alumno->persona->documento, 0, ".", ".")}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control w-full text-right" value="{{$alumno->persona->nombre}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Apellido</label>
                        <input type="text" class="form-control w-full text-right" value="{{$alumno->persona->apellido}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Celular</label>
                        <input type="text" name="celular" class="form-control w-full" value="{{$alumno->persona->celular}}">
                    </div>
                </div>

                <h3>Detalle de Pago</h3>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Cursos a Inscribirse</label>
                        <input type="text" class="form-control w-full text-right" value="{{$cursoHabilitado->curso->descripcion}}" readonly>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="">Curso Precio</label>
                        <input type="text" class="form-control w-full text-right" value="{{number_format($cursoHabilitado->precio, 0, ".", ".")}}" id="curso_precio" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Total a pagar</label>
                        <input type="text" class="form-control w-full text-right" name="total_pagar" id="total_pagar"
                        value="0" onkeyup="punto_decimal_limite_precio(this)" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Forma de Pago</label>
                        <select name="forma_pago_id" id="forma_pago_id" class="form-control">
                            @foreach ($forma_pago as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="form-row">
                    <button class="btn btn-success" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Inscribir</button>
                </div>
            </form>


        </div>

    </div>

    {{-- @livewire('ingreso-matricula.ingreso-curso', ['alumno' => $alumno], key($alumno->id)) --}}

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('js/ingreso/curso.js')}}"></script>
@endsection
