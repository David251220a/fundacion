<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <div class="row ml-1">
                <button class="btn btn-outline-primary mb-2" wire:click=render>Refresh</button>
            </div>
            <table id="" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">#ID</th>
                        <th width="30%">Insumo</th>
                        <th width="30%" class="text-right">Importe</th>
                        <th width="10%">Fecha Pago</th>
                        <th width="10%">Usuario</th>
                        <th class="no-content">Imprimir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->pago_id, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->concepto->descripcion}}
                                @if ($item->insumo_id <= 3)
                                    / {{str_pad($item->pago->mes, 2, '0', STR_PAD_LEFT)}}-
                                    {{$item->pago->año}}
                                @endif
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->importe, 0, ".", ".")}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{date('d/m/Y H:i', strtotime($item->created_at))}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{$item->usuario->name}}
                            </td>
                            <td class="text-right; font-size: 11px">
                                <a href="{{route('pdf.recibo_pago_varios', $item->pago_id)}}" target="__blank">
                                    <i class="fas fa-file-pdf" style="font-size: 18px;
                                    color: rgb(144, 248, 112);"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

