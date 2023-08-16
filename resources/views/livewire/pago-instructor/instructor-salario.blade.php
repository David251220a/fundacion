<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <table id="" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Documento</th>
                        <th width="20%">Instructor</th>
                        <th width="30%">Curso</th>
                        <th width="8%">Fecha</th>
                        <th width="5%">Horario</th>
                        <th width="5%">Dias</th>
                        <th width="">Salario</th>
                        <th class="no-content">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cursos as $item)
                        <tr>
                            <td class="text-right; font-size: 11px">
                                {{number_format($item->instructor->persona->documento, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->instructor->persona->nombre}} {{$item->instructor->persona->apellido}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->curso_habilitado_id}} - {{$item->curso_habilitado->tipo_curso->descripcion}}:
                                {{$item->curso_habilitado->curso->descripcion}} <br> {{$item->curso_habilitado->curso->modulo->descripcion}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}}
                                a <br> {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('H:i', strtotime($item->curso_habilitado->hora_entrada))}}
                                a <br> {{date('H:i', strtotime($item->curso_habilitado->hora_salida))}}
                            </td>
                            <td style="font-size: 11px">
                                {{ ($item->curso_habilitado->lunes == 1 ? 'LUNES ' : '') }}
                                {{ ($item->curso_habilitado->martes == 1 ? 'MARTES ' : '')}}
                                {{ ($item->curso_habilitado->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                {{ ($item->curso_habilitado->jueves == 1 ? 'JUEVES ' : '')}}
                                {{ ($item->curso_habilitado->viernes == 1 ? 'VIERNES ' : '')}}
                                {{ ($item->curso_habilitado->sabado == 1 ? 'SABADO ' : '')}}
                                {{ ($item->curso_habilitado->domingo == 1 ? 'DOMINGO ' : '')}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                @php
                                    $neto_general = $item->importe - $item->instructor->egreso($item->curso_habilitado_id)->sum('importe');
                                @endphp
                                {{number_format($neto_general, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                <a wire:click="datos({{$item->curso_habilitado_id}})" data-toggle="modal" data-target="#modal_heredado_tab">
                                    <i class="fas fa-pen mr-2" style="font-size: 15px;
                                    color: rgb(247, 168, 50);"></i>
                                </a>

                                <a wire:click="datos_anticipo({{$item->curso_habilitado_id}})" data-toggle="modal" data-target="#modal_anticipo_heredado_tab">
                                    <i class="fas fa-comments-dollar" style="font-size: 15px;
                                    color: rgb(200, 236, 70);"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2">
        {{$cursos->links()}}
    </div>

    @include('modal.salario_edit')
    @include('modal.salario_anticipo')
    @include('modal.recibo_anticipo')
</div>
