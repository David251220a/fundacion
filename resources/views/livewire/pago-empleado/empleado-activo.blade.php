<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <div class="row ml-1">
                @can('pago_empleados.agregar_funcionario')
                    <button class="btn btn-outline-info mb-2 mr-2" data-toggle="modal" data-target="#modal_buscar">Agregar Empleado</button>
                @endcan

                @can('pago_empleados.create')
                    <a href="{{route('pago_empleados.create')}}" class="btn btn-outline-success mb-2 mr-2">Cierre Planilla</a>
                @endcan

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
                                @can('pago_empleados.editar')
                                    <a data-toggle="modal" data-target="#modal_salario_empleado_edit" wire:click="edit({{$item->id}})">
                                        <i class="fas fa-edit mr-2" style="font-size: 15px;
                                        color: rgb(52, 253, 220);" ></i>
                                    </a>
                                @endcan

                                @can('pago_empleados.anticipo')
                                    <a data-toggle="modal" data-target="#modal_salario_empleado_anticipo" wire:click="edit({{$item->id}})">
                                        <i class="fas fa-coins mr-2" style="font-size: 15px;
                                        color: rgb(247, 168, 50);"></i>
                                    </a>
                                @endcan

                                @can('pago_empleados.inactivo')
                                    <a onclick="eliminar({{$item->id}})">
                                        <i class="fas fa-times-circle mr-2" style="font-size: 15px;
                                        color: rgb(248, 93, 93);"></i>
                                    </a>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="" style="color: :white; font-size: 15px">Total</th>
                        <th class="text-right">{{$total_ingreso}}</th>
                        <th class="text-right">{{$total_egreso}}</th>
                        <th class="text-right">{{$total_neto}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-2">
        {{$data->links()}}
    </div>

    @include('modal.buscar_general')
    @include('modal.empleado_agregar')
    @include('modal.salario_empleado_edit')
    @include('modal.empleado_anticipo')
    @include('modal.recibo_anticipo_empleado')
</div>
