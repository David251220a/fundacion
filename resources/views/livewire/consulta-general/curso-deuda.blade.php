<div class="row" style="margin-top: -20px">
    <div id="flFormsGrid" class="col-lg-12">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputEmail4">Documento</label>
                <input type="text" wire:model.defer="search" class="form-control" onkeyup="punto_decimal(this)">
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">Accion</label> <br>
                <button type="button" class="btn btn-info btn-sm" wire:click="buscar">Buscar</button>
            </div>
        </div>
    </div>

    <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">
        <table id="" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="5%">Documento</th>
                    <th width="20%">Nombre</th>
                    <th width="20%">Curso</th>
                    <th width="30%">Detalle Curso</th>
                    <th width="10%">Saldo</th>
                    <th class="no-content">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)

                    <tr>
                        <td class="text-right" style="font-size: 11px">
                            {{number_format($item->alumno->persona->documento, 0, ".", ".")}}
                        </td>
                        <td style="font-size: 11px">
                            {{$item->alumno->persona->nombre}} {{$item->alumno->persona->apellido}}
                        </td>
                        <td style="font-size: 11px">
                            {{$item->curso_habilitado->id}} - {{$item->curso_habilitado->tipo_curso->descripcion}}: {{$item->curso_habilitado->curso->descripcion}}
                            {{$item->curso_habilitado->curso->modulo->descripcion}}
                        </td>
                        <td class="" style="font-size: 11px">
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
                        <td class="text-right" style="font-size: 11px">
                            {{number_format($item->saldo, 0, ".", ".")}}
                        </td>
                        <td>
                            @can('consulta.curso_deuda_cobrar')
                                <button type="button" wire:click="detalle({{$item->id}})" data-toggle="modal" data-target="#modal_agregar" class="btn btn-info btn-sm mr-2 mb-2">Cobrar</button>
                            @endcan

                            @can('consulta.curso_deuda_exonerar')
                                <button type="button" onclick="exonerar({{$item->id}})" class="btn btn-warning btn-sm mr-2 mb-2">Exonerar</button>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="" style="color: :white; font-size: 15px">Total</th>
                    <th class="text-right">{{$cursodeuda}}</th>
                    <th class="text-right"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mx-3">
        {{$data->links()}}
    </div>

    @include('modal.recibo_curso')
    @include('modal.cobro_pendiente')
</div>
