<div class="col-xl-12 col-lg-12 col-sm-12 mb-4">
    <div class="widget-content widget-content-area br-6 table-responsive">
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Accion</th>
                    <th>Curso</th>
                    <th>Periodo</th>
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
                            {{$item->curso_habilitado->curso->descripcion}} - {{$item->curso_habilitado->curso->modulo->descripcion}}
                        </td>
                        <td class="text-left">
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_desde))}} a
                            {{date('d/m/Y', strtotime($item->curso_habilitado->periodo_hasta))}}
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
            </tbody>
        </table>
    </div>

    @include('modal.cobro_pendiente')
    @include('modal.recibo_curso')
</div>
