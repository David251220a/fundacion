<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <div class="row ml-1">
                <button class="btn btn-outline-primary mb-2" wire:click=render>Refresh</button>
            </div>
            <table id="" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Documento</th>
                        <th width="30%">Nombre</th>
                        <th width="30%">Apellido</th>
                        <th width="10%">Ingreso</th>
                        <th width="10%">Egreso</th>
                        <th class="no-content">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->documento, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->nombre}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->apellido}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->ingreso->sum('importe'), 0, ".", ".")}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{number_format($item->egreso->sum('importe'), 0, ".", ".")}}
                            </td>
                            <td class="text-right; font-size: 11px">
                                @can('pago_empleados.activo')
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

    <div class="mt-2">
        {{$data->links()}}
    </div>

</div>
