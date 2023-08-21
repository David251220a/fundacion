<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <div class="row ml-1">
                <button class="btn btn-outline-info mb-2 mr-2" data-toggle="modal" data-target="#modal_nuevo_insumo">Agregar Insumo</button>
                <button class="btn btn-outline-primary mb-2" wire:click=render>Refresh</button>
            </div>
            <table id="" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">#ID</th>
                        <th width="30%">Insumo</th>
                        <th class="text-right" width="30%">Precio</th>
                        <th width="10%">Fecha Ult\Pago</th>
                        <th width="10%">Usuario</th>
                        <th class="no-content">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->id, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->descripcion}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->precio, 0, ".", ".")}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                @if (count($item->insumo) > 0)
                                    {{date('d/m/Y H:i', strtotime($item->insumo[0]->created_at))}}
                                @endif

                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{$item->usuario->name}}
                            </td>
                            <td class="text-right; font-size: 11px">
                                <a data-toggle="modal" data-target="#modal_pago_insumo" wire:click="edit({{$item->id}})">
                                    <i class="fas fa-dollar-sign mr-2" style="font-size: 15px;
                                    color: rgb(52, 253, 220);" ></i>
                                </a>
                                <a onclick="eliminar({{$item->id}})">
                                    <i class="fas fa-times-circle mr-2" style="font-size: 15px;
                                    color: rgb(248, 93, 93);"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th colspan="3" class="" style="color: :white; font-size: 15px">Total</th>
                        <th class="text-right">{{$total_ingreso}}</th>
                        <th class="text-right">{{$total_egreso}}</th>
                        <th class="text-right">{{$total_neto}}</th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>

    @include('modal.nuevo_insumo')
    @include('modal.pago_insumo')
    @include('modal.recibo_pago_vario')
</div>
