<div class="">

    <div class="form-row">
        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Documento</label>
            <input wire:model.defer="documento"  type="text" class="form-control text-right" onkeyup="punto_decimal(this)">
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Estado Alumno</label>
            <select wire:model.defer="estado_curso" class="form-control">
                <option value="99">--TODOS--</option>
                @foreach ($estado as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <label for="">Filtros</label>
            <select wire:model.defer="saldos" class="form-control">
                <option value="1">--TODOS--</option>
                <option value="2">CON SALDO</option>
                <option value="3">CANCELADO</option>
            </select>
        </div>

        <div class="col-md-2 col-sm-4 mb-4">
            <label for="" class="w-full" style="width: 100%">Accion</label>
            <button type="button" class="btn btn-info" onclick="actualizar()">Filtrar</button>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Nº</th>
                        <th width="5%">Documento</th>
                        <th width="15%">Nombre</th>
                        <th width="15%">Apellido</th>
                        <th width="5%">Celular</th>
                        <th width="10%">Estado</th>
                        <th style="text-align: right">Saldo M</th>
                        <th style="text-align: right">Saldo C</th>
                        <th class="text-center no-content">Actions</th>
                    </tr>
                </thead>
                @php
                    $estilo_estado = 'padding: 3px 3px;
                                    border: 1px solid blueviolet;
                                    border-radius: 5px;
                                    background: blueviolet;
                                    color: white;
                                    ';
                    $estilo_estado_cuenta = 'padding: 3px 3px;
                                    border: 1px solid #3a89ff;
                                    border-radius: 5px;
                                    background: #3a89ff;
                                    color:white;
                                    margin-bottom : 2px';
                    $estilo_matri = 'padding: 3px 3px;
                                    border: 1px solid #179109;
                                    border-radius: 5px;
                                    background: #179109;
                                    color:white;
                                    margin-right: 15px;';
                    $estilo_cer = 'padding: 3px 3px;
                                    border: 1px solid #9e01a1;
                                    border-radius: 5px;
                                    background: #9e01a1;
                                    color:white;
                                    margin-right: 15px;';

                @endphp
                <tbody>

                    @foreach ($alumnos as $item)
                        @php

                            if($item->monto_abonado >=  $item->total_pagar){
                                $color = 'background: rgb(148 235 122)';
                            }
                            elseif ($item->monto_abonado > 0){
                                $color = 'background: rgb(241 226 46)';
                            }elseif($item->saldo > 0) {
                                $color = 'background: rgb(217 96 96)';
                            }
                        @endphp
                        <tr style="{{$color}}; ">
                            <td style="font-weight: bold; color:black; font-size:15px">{{$loop->iteration}}</td>
                            <td class="text-right text-bold" style="font-weight: bold; color:black; font-size:15px">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">{{$item->alumno->persona->nombre}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">{{$item->alumno->persona->apellido}}</td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">
                                {{ str_replace('-', '', $item->alumno->persona->celular)}}
                            </td>
                            <td class="" style="font-weight: bold; color:black; font-size:15px">
                                {{-- <button type="button" data-toggle="modal" data-target="#modal_estado" onclick="datos({{$item->id}})" class="btn btn-dark btn-sm mb-2">
                                    {{$item->estado_alumno->descripcion}}
                                </button> --}}
                                <a style="{{$estilo_estado}}" data-toggle="modal" data-target="#modal_estado" onclick="datos({{$item->id}})">{{$item->estado_alumno->descripcion}}</a>
                            </td>
                            <td class="text-right" style="font-weight: bold; color:black; font-size:15px">
                                {{number_format($item->saldo, 0, ".", ".")}}
                            </td>
                            <td class="text-right" style="font-weight: bold; color:black; font-size:15px">
                                {{number_format($item->certificado_saldo, 0, ".", ".")}}
                            </td>
                            <td class="text-center" style="font-weight: bold; color:black; font-size:15px">
                                @if ($item->saldo > 0)
                                    {{-- <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#modal_agregar" onclick="datos({{$item->id}})">Cobrar</button> --}}
                                    <a class="bs-popover" style="{{$estilo_matri}}" data-toggle="modal" data-target="#modal_agregar" onclick="datos({{$item->id}})" data-container="body"  data-trigger="hover"
                                    data-content="Cobro Matricula" data-placement="top">
                                        <i class="fas fa-hand-holding-usd"></i>
                                        {{-- Cobrar --}}
                                    </a>
                                @endif

                                @if ($item->certificado_saldo > 0)
                                    {{-- <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#modal_agregar" onclick="datos({{$item->id}})">Cobrar</button> --}}
                                    <a class="bs-popover" style="{{$estilo_cer}}" data-toggle="modal" data-target="#modal_agregar_certificado" onclick="datos({{$item->id}})" data-container="body"  data-trigger="hover"
                                    data-content="Cobro Certificado" data-placement="top">
                                        <i class="fas fa-graduation-cap"></i>{{-- Cobrar --}}
                                    </a>
                                @endif

                                {{-- <a class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#moda_estado_cuenta" onclick="estado_cuenta({{$item->id}}, {{$item->alumno_id}})">Estado Cuenta</a> --}}
                                <a class="bs-popover" style="{{$estilo_estado_cuenta}}" data-toggle="modal" data-target="#moda_estado_cuenta" onclick="estado_cuenta({{$item->id}}, {{$item->alumno_id}})"
                                data-container="body"  data-trigger="hover"
                                data-content="Estado de Cuenta" data-placement="top">
                                    <i class="fas fa-balance-scale-right"></i>
                                    {{-- Estado Cuenta --}}
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="color: white">
                    <td colspan="3">
                        Cantidad Alumnos : {{count($alumnos)}}
                    </td>
                    <td colspan="2">
                        TOTAL SALDO
                    </td>
                    <td class="text-right">
                        {{number_format($total_saldo, 0, ".", ".")}}
                    </td>
                    <td class="text-right">
                        {{number_format($alumnos->sum('certificado_saldo'), 0, ".", ".")}}
                    </td>
                </tfoot>
            </table>
        </div>
    </div>

    @include('modal.cobrar_matricula')
    @include('modal.cambio_estado')
    @include('modal.estado_cuenta')
    @include('modal.cobrar_certificado')
    @include('modal.recibo_curso')
</div>
