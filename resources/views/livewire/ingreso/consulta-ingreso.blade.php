<div class="col-lg-12 layout-spacing mt-4">
    <div class="widget-content widget-content-area">

        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="w-25">Ingreso Varios</h2>
        </div>

        <div class="form-row mx-4">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <h4 class="mb-2">Filtros</h4>
            </div>

            <div class="col-md-2  mb-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked onclick="filtro(1)">
                    <label class="custom-control-label" for="customRadioInline1">Por Fecha</label>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" onclick="filtro(2)">
                    <label class="custom-control-label" for="customRadioInline2">Por numero de recibo</label>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input" onclick="filtro(3)">
                    <label class="custom-control-label" for="customRadioInline3">Por Documento</label>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input" onclick="filtro(4)">
                    <label class="custom-control-label" for="customRadioInline4">Familia</label>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline5" name="customRadioInline1" class="custom-control-input" onclick="filtro(5)">
                    <label class="custom-control-label" for="customRadioInline5">Curso</label>
                </div>
            </div>

        </div>

        {{-- <form action="{{route('ingreso_varios.index')}}" method="GET" class=""> --}}
            <div class="form-row mx-4">
                <div class="col-md-3 mb-4" style="display: {{$ver_fecha}}">
                    <label for="">Fecha Desde</label>
                    <input wire:model.defer="fecha_actual" type="date" class="form-control text-right" required>
                </div>

                <div class="col-md-3 mb-4" style="display: {{$ver_fecha}}">
                    <label for="">Fecha Hasta</label>
                    <input wire:model.defer="fecha_hasta" type="date" class="form-control text-right" required>
                </div>

                <div class="col-md-3  mb-4" id="ver_recibo" style="display: {{$ver_recibo}}">
                    <label for="">Nº Recibo</label>
                    <input wire:model.defer="recibo" type="text" class="form-control text-right">
                </div>

                <div class="col-md-3  mb-4" id="ver_documento" style="display: {{$ver_documento}}">
                    <label for="">Documento</label>
                    <input wire:model.defer="documento" type="text" class="form-control text-right" onkeyup="punto_decimal(this)" onchange="punto_decimal(this)">
                </div>

                <div class="col-md-3  mb-4" id="ver_tipo_curso_id" style="display: {{$ver_familia}}">
                    <label for="">Tipo de Curso</label>
                    <select wire:model.defer="aux_familia_id" class="form-control" onchange="actualizar_curso()">
                        @foreach ($aux_familia as $item)
                            <option value="{{$item->id}}">{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3  mb-4" id="ver_curso" style="display: {{$ver_curso}}">
                    <label for="">Curso</label>
                    <select wire:model.defer="aux_curso_id" class="form-control">
                        @foreach ($aux_curso as $item)
                            <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->modulo->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3  mb-4">
                    <label for="" class="w-full">Accion</label>
                    <br>
                    <button wire:click="render" type="button" class="btn btn-info">Filtrar</button>
                    <button type="submit" class="btn btn-warning ">Atras</button>
                </div>

                <div class="col-md-3  mb-4">
                    <form action="{{route('ingreso_vario.ingreso_varios_reporte', $caso)}}" method="get" target="__blank">
                        <label for="" class="w-full">PDF</label>
                        <input type="hidden" name="fecha_actual" value="{{$fecha_actual}}">
                        <input type="hidden" name="fecha_hasta" value="{{$fecha_hasta}}">
                        <input type="hidden" name="recibo" value="{{$recibo}}">
                        <input type="hidden" name="documento" value="{{$documento}}">
                        <input type="hidden" name="aux_familia_id" value="{{$aux_familia_id}}">
                        <input type="hidden" name="aux_curso_id" value="{{$aux_curso_id}}">
                        <br>
                        <button class="btn btn-info">Ver</button>
                    </form>

                </div>

            </div>
        {{-- </form> --}}

        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget-content widget-content-area br-6 table-responsive">
                <table id="" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>N° Recibo</th>
                            <th>Persona</th>
                            <th>Detalle</th>
                            <th>Fecha Pago</th>
                            <th>Monto</th>
                            <th>Forma Pago</th>
                            <th class="no-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-right">{{$item->numero_recibo}}</td>
                                <td>
                                    {{number_format($item->persona->documento, 0, ".", ".")}} -
                                    {{$item->persona->nombre}}
                                    {{$item->persona->apellido}}
                                </td>
                                <td>
                                    @if ($item->curso_ingreso_id > 0)
                                        Familia: {{ $item->familia->descripcion }}
                                        <br>
                                        Curso: {{$item->cursos->descripcion}} - {{$item->cursos->modulo->descripcion}}
                                    @endif

                                    @foreach ($item->detalle as $det)
                                        <p>* {{$det->concepto->descripcion}}</p>
                                    @endforeach
                                </td>
                                <td>
                                    {{date('d/m/Y H:i', strtotime($item->created_at))}}
                                </td>
                                <td>
                                    {{number_format($item->total_pagado, 0, ".", ".")}}
                                </td>
                                <td>
                                    {{$item->forma_pago->descripcion}}
                                </td>
                                <td>
                                    <button type="button" onclick="anular({{$item->id}})" class="btn btn-danger btn-sm">Anular</button>
                                    <button type="button" onclick="datos({{$item->id}})" class="btn btn-info btn-sm">Ver recibo</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="font-size: 18px">Totales</th>
                            <th colspan="2" class="text-right" style="font-size: 18px">{{number_format($totales, 0, ".", ".")}}</th>
                            <th class="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="ml-4 mt-4">
            {{$data->links()}}
        </div>

    </div>

    @include('modal.recibo')
</div>
