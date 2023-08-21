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
                                @can('pago_varios.activar')
                                    <a onclick="activar({{$item->id}})" style="border: 1px solid greenyellow;
                                        padding: 1px 2px;
                                        border-radius: 30%;
                                    }">
                                        <i class="fas fa-check" style="font-size: 15px;
                                        color: rgb(144, 248, 112);"></i>
                                    </a>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
