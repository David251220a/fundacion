@include('modal.head')

<div class="modal-body">
    <div class="mb-2 ml-3">

        @if (!(empty($instructor)))
            <div class="row">
                <label for="">
                    Nombre y Apellido: {{number_format($instructor->persona->documento, 0, ".", ".")}}
                    {{$instructor->persona->nombre}} {{$instructor->persona->apellido}}
                </label>
            </div>
            <div class="row" style="margin-top: -10px">
                <label for="">
                    Curso: {{$curso->id}} - {{$curso->tipo_curso->descripcion}}:
                    {{$curso->curso->descripcion}} - {{$curso->curso->modulo->descripcion}}
                </label>
            </div>
            <div class="row" style="margin-top: -10px">
                <label for="">
                    Periodo: {{date('d/m/Y', strtotime($curso->periodo_desde))}}
                    a {{date('d/m/Y', strtotime($curso->periodo_hasta))}}
                    | Hora: {{date('H:i', strtotime($curso->hora_entrada))}}
                    a {{date('H:i', strtotime($curso->hora_salida))}}
                    | Dia: {{ ($item->lunes == 1 ? 'LUNES ' : '') }}
                    {{ ($curso->martes == 1 ? 'MARTES ' : '')}}
                    {{ ($curso->miercoles == 1 ? 'MIERCOLES ' : '')}}
                    {{ ($curso->jueves == 1 ? 'JUEVES ' : '')}}
                    {{ ($curso->viernes == 1 ? 'VIERNES ' : '')}}
                    {{ ($curso->sabado == 1 ? 'SABADO ' : '')}}
                    {{ ($curso->domingo == 1 ? 'DOMINGO ' : '')}}
                </label>
            </div>
        @endif
    </div>

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Salario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Anticipo</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h4 style="margin-top: -20px">Ingreso</h4>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <label for="">Concepto</label>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <label class="text-right" for="">Monto</label>
                </div>

                @for ($i = 0; $i < count($concepto_id); $i++)
                    <div class="col-md-6 col-sm-6 mb-1" >
                        <input type="text" class="form-control" value="{{$descripcion_concepto[$i]}}" readonly>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-1">
                        <input type="text" wire:model="monto_concepto.{{$i}}" class="form-control text-right" onkeyup="punto_decimal_limite(this)">
                    </div>
                @endfor

            </div>

            <hr>

            <h4 class="">Egreso</h4>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <label for="">Concepto</label>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <label class="text-right" for="">Monto</label>
                </div>

                @for ($i = 0; $i < count($e_concepto_id); $i++)
                    <div class="col-md-6 col-sm-6 mb-1" >
                        <label for="">{{$e_descripcion_concepto[$i]}}</label>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-1 text-right">
                        <label class="text-right" for="">-{{$e_monto_concepto[$i]}}</label>
                    </div>
                @endfor


            </div>

            <hr>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <p style="font-size: 20px;color:white"> <b>Ingreso Neto:</b></p>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <input type="text" style="color: white; font-weight: bold" class="form-control text-right" value="{{$neto}}" readonly>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
                <table id="" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="60%">Concepto</th>
                            <th width="20%">Fecha</th>
                            <th width="20%">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($anticipo_detalle) > 0)
                            @foreach ($anticipo_detalle as $item)
                                <tr>
                                    <td style="font-size: 11px">
                                        {{$item->concepto->descripcion}}
                                    </td>
                                    <td style="font-size: 11px">
                                        {{date('d/m/Y H:i', strtotime($item->created_at))}}
                                    </td>
                                    <td class="text-right" style="font-size: 11px">
                                        {{number_format($item->importe, 0, ".", ".")}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="color: white;font-size: 15px">Total Egreso</th>
                            <th colspan="2" class="text-right" style="color: white;font-size: 15px">
                                @if (count($anticipo_detalle) > 0)
                                    <b> {{number_format($anticipo_detalle->sum('importe'), 0, ".", ".")}}</b>
                                @else
                                    <b>0</b>
                                @endif
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

@include('modal.footer')
