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
            <button type="button" class="btn btn-info" wire:click="render">Filtrar</button>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Nº</th>
                        <th width="10%">Documento</th>
                        <th width="20%">Nombre</th>
                        <th width="20%">Apellido</th>
                        <th>Estado</th>
                        {{-- <th>Saldo</th> --}}
                        <th class="text-center no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $item)
                        <tr style="color: white">
                            <td>{{$loop->iteration}}</td>
                            <td class="text-right text-bold" style="font-weight: bold; font-size:15px">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                            <td class="" style="font-weight: bold; font-size:15px">{{$item->alumno->persona->nombre}}</td>
                            <td class="" style="font-weight: bold; font-size:15px">{{$item->alumno->persona->apellido}}</td>
                            <td class="" style="font-weight: bold; font-size:15px">
                                {{$item->estado_alumno->descripcion}}
                            </td>
                            {{-- <td class="text-right" style="font-weight: bold; font-size:15px">
                                {{number_format($item->saldo, 0, ".", ".")}}
                            </td> --}}
                            <td class="text-center" style="font-weight: bold; font-size:15px">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="color: white">
                    <td colspan="2">
                        Cantidad Alumnos : {{count($alumnos)}}
                    </td>
                    <td colspan="3">
                        TOTAL SALDO
                    </td>
                    <td class="text-right">
                        {{number_format($total_saldo, 0, ".", ".")}}
                    </td>
                    <td></td>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- @include('modal.cobrar_matricula')
    @include('modal.cambio_estado')
    @include('modal.estado_cuenta') --}}
</div>
