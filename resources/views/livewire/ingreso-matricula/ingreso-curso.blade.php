<div class="col-xl-12 col-lg-12 col-sm-12 mb-4">
    <div class="widget-content widget-content-area br-6 table-responsive">
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Accion</th>
                    <th>Curso</th>
                    <th>Periodo</th>
                    <th>Tipo Cobro</th>
                    <th>Concluido</th>
                    <th>Aprobo</th>
                    <th>Total a Pagar</th>
                    <th>Monto Pagado</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curso as $item)
                    <tr>
                        <td>
                            <button type="button" wire:click="detalle({{$item->id}})" class="btn btn-info btn-sm mr-2 mb-2">Cobrar</button>
                        </td>
                        <td class="text-left">
                            {{$item->curso_habilitado->id}}-{{$item->curso_habilitado->curso->descripcion}} - {{$item->curso_habilitado->curso->modulo->descripcion}}
                        </td>
                        <td class="text-left">
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}} - <br>
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}}
                        </td>
                        <td>
                            MATRICULA
                        </td>
                        <td class="text-left">
                            {{ ($item->curso_habilitado->concluido == 1 ? 'SI' : 'NO' ) }}
                        </td>
                        <td class="text-left">
                            {{ ($item->aprobado == 1 ? 'SI' : 'NO' ) }}
                        </td>
                        <td class="text-right">
                            {{number_format($item->total_pagar, 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->monto_abonado, 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->saldo, 0, ".", ".")}}
                        </td>
                    </tr>
                @endforeach

                @foreach ($certificado as $item)
                    <tr>
                        <td>
                            <button type="button" onclick="datos({{$item->id}})" data-toggle="modal" data-target="#modal_agregar_certificado"  class="btn btn-warning btn-sm mr-2 mb-2">Cobrar</button>
                        </td>
                        <td class="text-left">
                            {{$item->curso_habilitado->id}}-
                            {{$item->curso_habilitado->curso->descripcion}} - {{$item->curso_habilitado->curso->modulo->descripcion}}
                        </td>
                        <td class="text-left">
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}} - <br>
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}}
                        </td>
                        <td>
                            CERTIFICADO
                        </td>
                        <td class="text-left">
                            {{ ($item->curso_habilitado->concluido == 1 ? 'SI' : 'NO' ) }}
                        </td>
                        <td class="text-left">
                            {{ ($item->aprobado == 1 ? 'SI' : 'NO' ) }}
                        </td>
                        <td class="text-right">
                            {{number_format($item->certificado_monto, 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->certificado_pagado, 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->certificado_saldo, 0, ".", ".")}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('modal.cobro_pendiente')
    @include('modal.recibo_curso')
    @include('modal.cobrar_certificado')
</div>
