@include('modal.head_anticipo')

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
                    | Hora: {{date('H:i', strtotime($item->hora_entrada))}}
                    a {{date('H:i', strtotime($item->hora_salida))}}
                    | Dia: {{ ($item->lunes == 1 ? 'LUNES ' : '') }}
                    {{ ($item->martes == 1 ? 'MARTES ' : '')}}
                    {{ ($item->miercoles == 1 ? 'MIERCOLES ' : '')}}
                    {{ ($item->jueves == 1 ? 'JUEVES ' : '')}}
                    {{ ($item->viernes == 1 ? 'VIERNES ' : '')}}
                    {{ ($item->sabado == 1 ? 'SABADO ' : '')}}
                    {{ ($item->domingo == 1 ? 'DOMINGO ' : '')}}
                </label>
            </div>
        @endif
    </div>

    <div class="table-responsive mt-1">
        <table id="" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th colspan="2">
                        Ingreso y Egreso
                    </th>
                </tr>
                <tr>
                    <th>Concepto</th>
                    <th class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Remuneracion</td>
                    <td class="text-right">{{$neto_salario}}</td>
                </tr>
                <tr>
                    <td>Total Egreso</td>
                    <td class="text-right">{{($egreso > 0 ? '-': '')}}{{$egreso}}</td>
                </tr>
            </tbody>
            <tfoot style="color: white;">
                <tr>
                    <td>
                        <b>Total Ingreso Neto:</b>
                    </td>
                    <td class="text-right">
                        <b>{{$neto}}</b>
                        <input type="hidden" id="curso_precio" value="{{$neto}}">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="col-12">
        <label for="">Monto Anticipo</label>
        <input type="text" class="form-control" onkeyup="punto_decimal_limite_precio(this)">
    </div>
</div>

@include('modal.footer_anticpo')
