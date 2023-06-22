<div class="">

    <div class="form-row">
        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Documento</label>
            <input wire:model.defer="documento"  type="text" class="form-control text-right" onkeyup="punto_decimal(this)">
        </div>

        <div class="col-md-4 col-sm-6 mb-4">
            <label for="">Estado Alumno</label>
            <select wire:model.defer="estado_curso" class="form-control">
                <option value="99">--TODOS--</option>
                @foreach ($estado as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 col-sm-4 mb-4">
            <label for="" class="w-full" style="width: 100%">Accion</label>
            <button type="button" class="btn btn-info" onclick="actualizar()">Filtrar</button>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Estado</th>
                        <th>Saldo</th>
                        <th class="text-center no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $item)
                        @php

                            if($item->saldo > 0){
                                $color = 'background: rgb(250, 52, 52)';
                            }else {
                                $color = 'background: rgb(99, 250, 53)';
                            }
                        @endphp
                        <tr style="{{$color}};">
                            <td class="text-right text-bold" style="font-weight: bold; color:black; font-size:15px">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">{{$item->alumno->persona->nombre}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">{{$item->alumno->persona->apellido}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">
                                <button type="button" data-toggle="modal" data-target="#modal_estado" onclick="datos({{$item->id}})" class="btn btn-dark btn-sm mb-2">
                                    {{$item->estado_alumno->descripcion}}
                                </button>
                            </td>
                            <td class="text-right" style="font-weight: bold; color:black; font-size:15px">
                                {{number_format($item->saldo, 0, ".", ".")}}
                            </td>
                            <td class="text-center" style="font-weight: bold; color:black; font-size:15px">
                                @if ($item->saldo > 0)
                                    <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#modal_agregar" onclick="datos({{$item->id}})">Cobrar</button>
                                @endif

                                <a class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#moda_estado_cuenta" onclick="estado_cuenta({{$item->id}}, {{$item->alumno_id}})">Estado Cuenta</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="color: white">
                    <td colspan="4">
                        TOTAL SALDO
                    </td>
                    <td class="text-right">
                        {{number_format($total_saldo, 0, ".", ".")}}
                    </td>
                </tfoot>
            </table>
        </div>
    </div>

    @include('modal.cobrar_matricula')
    @include('modal.cambio_estado')
    @include('modal.estado_cuenta')
</div>
