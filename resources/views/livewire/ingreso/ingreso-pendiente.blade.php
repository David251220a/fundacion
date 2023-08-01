<div class="col-xl-12 col-lg-12 col-sm-12 mb-4">
    <div class="widget-content widget-content-area br-6 table-responsive">
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Accion</th>
                    <th>Fecha Cobro</th>
                    <th>Total a Pagar</th>
                    <th>Monto Pagado</th>
                    <th>Saldo</th>
                    <th>Detalle Saldos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendiente as $item)
                    <tr>
                        <td>
                            <button type="button" wire:click="detalle({{$item->id}})" class="btn btn-info btn-sm mr-2 mb-2">Cobrar</button>
                        </td>
                        <td>
                            {{date('d/m/Y H:i', strtotime($item->created_at))}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->detalle->sum('total_pagar'), 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->detalle->sum('monto_pagado'), 0, ".", ".")}}
                        </td>
                        <td class="text-right">
                            {{number_format($item->detalle->sum('saldo'), 0, ".", ".")}}
                        </td>
                        <td>
                            @foreach ($item->detalle as $det)
                                @if ($det->saldo > 0)
                                    {{number_format($det->saldo, 0, ".", ".")}} - {{$det->producto->descripcion}}
                                    <br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('modal.cobro_pendiente')
    @include('modal.recibo')
</div>
