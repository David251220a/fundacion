<div class="">

    <div class="form-row">
        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Documento</label>
            <input wire:model.defer="documento"  type="text" class="form-control text-right" onkeyup="punto_decimal(this)">
        </div>

        <div class="col-md-8 col-sm-4 mb-4">
            <label for="" class="w-full" style="width: 100%">Accion</label>
            <button type="button" class="btn btn-info" onclick="actualizar()">Filtrar</button>
            <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_insumo">Agregar Insumo</button>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%" rowspan="2">Nº</th>
                        <th width="5%" rowspan="2">Documento</th>
                        <th width="10%" rowspan="2">Nombre</th>
                        <th width="10%" rowspan="2">Apellido</th>
                        @foreach ($cursoHabilitado->insumos as $item)
                            <th colspan="2" class="text-center">
                                Clase {{$item->clase}}
                                <br>
                                {{date('d/m/Y', strtotime($item->fecha))}}
                            </th>
                        @endforeach
                </thead>
                <tbody>
                    @foreach ($alumnos as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="text-right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                            <td class="">{{$item->alumno->persona->nombre}}</td>
                            <td class="">{{$item->alumno->persona->apellido}}</td>
                            @foreach ($cursoHabilitado->insumos as $cab)
                                @php
                                    $relacion = $cab->alumnos;
                                    $existe = $relacion->where('alumno_id', $item->alumno_id)->where('estado_id', 1);
                                    if($item->total_pagado >=  $item->total_pagar){
                                        $color = 'background: rgb(148 235 122)';
                                    }
                                    elseif ($item->total_pagado > 0){
                                        $color = 'background: rgb(241 226 46)';
                                    }elseif($item->saldo > 0) {
                                        $color = 'background: rgb(217 96 96)';
                                    }

                                    foreach ($existe as $a) {
                                        $valor = $a->saldo;
                                        $id = $a->id;
                                    }
                                @endphp
                                @if ($existe)
                                    <td width="10%" class="text-right" style="font-weight: bold; color:black;{{$color}}">
                                        {{number_format($valor, 0, ".", ".")}}
                                    </td>
                                    <td width="10%">
                                        <button class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#modal_cobrar_insumo" onclick="datos_insumo({{$id}})">
                                            <i class="fas fa-coins"></i>
                                        </button>
                                    </td>
                                @else
                                    <td width="10%" >No hyay</td>
                                    <td width="10%" >No hyay</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('modal.agregar_insumo')
    @include('modal.cobrar_insumo')
</div>
