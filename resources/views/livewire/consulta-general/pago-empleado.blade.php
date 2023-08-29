<div class="row" style="margin-top: -20px">
    <div id="flFormsGrid" class="col-lg-12">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputEmail4">Documento</label>
                <input type="text" wire:model.defer="search" class="form-control" onkeyup="punto_decimal(this)">
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">Fecha Desde</label>
                <input type="date" wire:model.defer="fecha_desde" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">Fecha Hasta</label>
                <input type="date" wire:model.defer="fecha_hasta" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">Accion</label> <br>
                <button type="button" class="btn btn-info btn-sm" wire:click="buscar_empleado">Buscar</button>
            </div>
        </div>
    </div>

    <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">
        <table id="" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Tipo Pago</th>
                    <th>Fecha Pago</th>
                    <th>Importe</th>
                    {{-- <th class="no-content">Acción</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-right" style="font-size: 11px">
                            {{number_format($item->empleado->persona->documento, 0, ".", ".")}}
                        </td>
                        <td style="font-size: 11px">
                            {{$item->empleado->persona->nombre}} {{$item->empleado->persona->apellido}}
                        </td>
                        <td class="text-center" style="font-size: 11px">
                            @php
                                $nuevo = str_replace('INSTRUCTORES', '', $item->pago->tipo_pago->descripcion);
                                $nuevo = str_replace('- INSTRUCTORES', '', $item->pago->tipo_pago->descripcion);
                            @endphp
                            {{$nuevo}}
                        </td>
                        <td class="text-center" style="font-size: 11px">
                            {{date('d/m/Y H:i', strtotime($item->created_at))}}
                        </td>
                        <td class="text-right" style="font-size: 11px">
                            {{number_format($item->importe, 0, ".", ".")}}
                        </td>
                        {{-- <td>
                            @if ($item->pago->pago_tipo_id == 5)
                                <a onclick="anular_instructor({{$item->pago_id}})" style="font-size: 11px; color: red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                </a>
                            @endif

                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="" style="color: :white; font-size: 15px">Total</th>
                    <th colspan="2" class="text-right">{{number_format($total_pago_empleado, 0, ".", ".")}}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    @if ($data)
        <div class="row mx-4">
            {{$data->links()}}
        </div>
    @endif
</div>
