<div class="row" style="margin-top: -20px">
    <div id="flFormsGrid" class="col-lg-12">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputEmail4">Documento</label>
                <input type="text" wire:model.defer="search" class="form-control" onkeyup="punto_decimal(this)">
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">Accion</label> <br>
                <button type="button" class="btn btn-info btn-sm" wire:click="buscar_insumo">Buscar</button>
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
                    <th width="8%">Fecha Insumo</th>
                    <th width="10%">Saldo</th>
                    <th class="no-content">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)

                    @if (count($item->cursoHabilitado->alumnos_cursando->where('alumno_id', $item->alumno_id)->whereIn('curso_a_estado_id', [1, 2, 3, 7])) > 0)
                        <tr>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->documento, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->nombre}} {{$item->apellido}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->cursoHabilitado->id}} - {{$item->cursoHabilitado->tipo_curso->descripcion}}: {{$item->cursoHabilitado->curso->descripcion}}
                                {{$item->cursoHabilitado->curso->modulo->descripcion}}
                            </td>
                            <td class="" style="font-size: 11px">
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
                            <td class="text-center" style="font-size: 11px">
                                {{date('d/m/Y', strtotime($item->fecha))}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->saldo, 0, ".", ".")}}
                            </td>
                            <td>
                                @can('consulta.insumo_cobrar')
                                    <button type="button" wire:click="detalle_insumo({{$item->id}})" data-toggle="modal" data-target="#modal_cobrar_insumo" class="btn btn-info btn-sm mr-2 mb-2">Cobrar</button>
                                @endcan
                                @can('consulta.insumo_exonerar')
                                    <button type="button" onclick="exonerar_insumo({{$item->id}})" class="btn btn-warning btn-sm mr-2 mb-2">Exonerar</button>
                                @endcan

                            </td>
                        </tr>
                    @endif

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="" style="color: :white; font-size: 15px">Total</th>
                    <th class="text-right">{{$total_saldo}}</th>
                    <th class="text-right"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mx-3">
        {{$data->links()}}
    </div>

    @include('modal.recibo_ingreso')
    @include('modal.cobrar_insumo')
</div>
