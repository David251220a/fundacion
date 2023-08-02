<div class="">

    {{-- <div class="form-row">
        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Documento</label>
            <input wire:model.defer="documento"  type="text" class="form-control text-right" onkeyup="punto_decimal(this)">
        </div>

        <div class="col-md-8 col-sm-4 mb-4">
            <label for="" class="w-full" style="width: 100%">Accion</label>
            <button type="button" class="btn btn-info mb-2" onclick="actualizar()">Filtrar</button>
        </div>
    </div> --}}

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="" class="table dt-table-hover table-border" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%" rowspan="2">Nº</th>
                        <th width="5%" rowspan="2">Documento</th>
                        <th width="10%" rowspan="2">Nombre</th>
                        <th width="10%" rowspan="2">Apellido</th>
                        @foreach ($cursoHabilitado->insumos as $item)
                            <th width="10%"class="text-center">
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
                                    foreach ($existe as $a) {
                                        $valor = $a->saldo;
                                        $id = $a->id;
                                        if($a->total_pagado >=  $a->total_pagar){
                                            $color = 'background: rgb(148 235 122)';
                                        }elseif ($a->total_pagado > 0){
                                            $color = 'background: rgb(241 226 46)';
                                        }elseif($a->saldo > 0) {
                                            $color = 'background: rgb(217 96 96)';
                                        }
                                    }
                                @endphp
                                @if (count($existe) > 0)
                                    <td width="10%" class="text-right" style="font-weight: bold; color:black;{{$color}}; border: 2px solid black">
                                    </td>
                                @else
                                    <td class="text-center" width="10%" style="font-weight: bold" >X</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
