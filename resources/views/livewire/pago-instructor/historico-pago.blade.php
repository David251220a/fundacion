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
                        <th width="">Pago Neto</th>
                        <th class="no-content">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $neto_general = 0;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-right; font-size: 11px">
                                {{number_format($item->pago_instructor[0]->instructor->persona->documento, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->pago_instructor[0]->instructor->persona->nombre}} {{$item->pago_instructor[0]->instructor->persona->apellido}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->pago_instructor[0]->curso_habilitado_id}} - {{$item->pago_instructor[0]->curso_habilitado->tipo_curso->descripcion}}:
                                {{$item->pago_instructor[0]->curso_habilitado->curso->descripcion}}
                                <br> {{$item->pago_instructor[0]->curso_habilitado->curso->modulo->descripcion}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('d/m/Y', strtotime($item->pago_instructor[0]->curso_habilitado->periodo_desde))}}
                                a <br> {{date('d/m/Y', strtotime($item->pago_instructor[0]->curso_habilitado->periodo_hasta))}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('H:i', strtotime($item->pago_instructor[0]->curso_habilitado->hora_entrada))}}
                                a <br> {{date('H:i', strtotime($item->pago_instructor[0]->curso_habilitado->hora_salida))}}
                            </td>
                            <td style="font-size: 11px">
                                {{ ($item->pago_instructor[0]->curso_habilitado->lunes == 1 ? 'LUNES ' : '') }}
                                {{ ($item->pago_instructor[0]->curso_habilitado->martes == 1 ? 'MARTES ' : '')}}
                                {{ ($item->pago_instructor[0]->curso_habilitado->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                {{ ($item->pago_instructor[0]->curso_habilitado->jueves == 1 ? 'JUEVES ' : '')}}
                                {{ ($item->pago_instructor[0]->curso_habilitado->viernes == 1 ? 'VIERNES ' : '')}}
                                {{ ($item->pago_instructor[0]->curso_habilitado->sabado == 1 ? 'SABADO ' : '')}}
                                {{ ($item->pago_instructor[0]->curso_habilitado->domingo == 1 ? 'DOMINGO ' : '')}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->importe, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                @can('pago_instructor.anular')
                                    <a onclick="anular({{$item->id}})" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: rgb(247, 31, 31)" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    </a>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <div class="mt-2">
        {{$data->links()}}
    </div> --}}
</div>
