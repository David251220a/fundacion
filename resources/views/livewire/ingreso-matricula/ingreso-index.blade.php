<div class="mx-4">
    <div class="form-row">
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <h4 class="mb-2">Filtros </h4>
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

        {{-- <div class="col-md-2 mb-4">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline4">Por Tipo de Curso</label>
            </div>
        </div>

        <div class="col-md-2 mb-4">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline5" name="customRadioInline1" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline5">Por Curso</label>
            </div>
        </div> --}}

    </div>

    <div class="form-row">
        <div class="col-md-3 mb-4" style="display:{{$ver_fecha}}">
            <label for="">Fecha</label>
            <input wire:model.defer="fecha_actual" type="date" class="form-control text-right">
        </div>

        <div class="col-md-3  mb-4" id="ver_recibo" style="display: {{$ver_recibo}}">
            <label for="">Nº Recibo</label>
            <input wire:model.defer="recibo" type="text" class="form-control text-right">
        </div>

        <div class="col-md-3  mb-4" id="ver_documento" style="display: {{$ver_documento}}">
            <label for="">Documento</label>
            <input wire:model.defer="documento" type="text" class="form-control text-right" onkeyup="punto_decimal(this)">
        </div>

        <div class="col-md-3  mb-4" id="ver_tipo_curso_id" style="display: none">
            <label for="">Tipo de Curso</label>
            <select wire:model.defer="tipo_curso_id" class="form-control">
                @foreach ($tipo_curso as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3  mb-4" id="ver_curso" style="display: none">
            <label for="">Curso</label>
            <select wire:model.defer="curso_id" class="form-control">
                @foreach ($curso as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3  mb-4">
            <label for="" class="w-full">Accion</label>
            <br>
            <button wire:click="render" type="button" class="btn btn-info">Filtrar</button>
        </div>
    </div>


    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>N° Recibo</th>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Fecha Pago</th>
                        <th>Monto</th>
                        <th>Forma Pago</th>
                        <th>Estado</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->numero_recibo}}</td>
                            <td>
                                {{number_format($item->alumno->persona->documento, 0, ".", ".")}} -
                                {{$item->alumno->persona->nombre}}
                                {{$item->alumno->persona->apellido}}
                            </td>
                            <td>
                                {{$item->detalle[0]->curso_habilitado->curso->descripcion}}
                            </td>
                            <td>
                                {{date('d/m/Y', strtotime($item->fecha_ingreso))}}
                            </td>
                            <td>
                                {{number_format($item->total_pagado, 0, ".", ".")}}
                            </td>
                            <td>
                                {{$item->forma_pago->descripcion}}
                            </td>
                            <td>
                                {{$item->estado->descripcion}}
                            </td>
                            <td>
                                <button type="button" onclick="anular({{$item->id}})" class="btn btn-danger btn-sm">Anular</button>
                                <button onclick="datos({{$item->id}})" type="button" class="btn btn-info btn-sm">Ver recibo</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 mx-2 mt-4">
            {{$data->links()}}
        </div>

    </div>

    @include('modal.recibo_curso')

</div>
