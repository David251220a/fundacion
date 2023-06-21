<div class="form-row">

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <h4 class="mb-2">Filtros</h4>
    </div>

    <div class="col-md-2 col-sm-6 mb-4">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked>
            <label class="custom-control-label" for="customRadioInline1">Por Fecha</label>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 mb-4">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">Por numero de recibo</label>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 mb-4">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline3">Por Documento</label>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 mb-4">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline4">Por Tipo de Curso</label>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 mb-4">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline5" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline5">Por Curso</label>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Fecha</label>
        <input wire:model.defer="fecha_actual" type="date" class="form-control text-right">
    </div>

    <div class="col-md-3 col-sm-6 mb-4" id="ver_documento" style="display: none">
        <label for="">Documento</label>
        <input wire:model.defer="documento" type="text" class="form-control text-right" placeholder="">
    </div>

    <div class="col-md-3 col-sm-6 mb-4" id="ver_tipo_curso_id" style="display: none">
        <label for="">Tipo de Curso</label>
        <select wire:model.defer="tipo_curso_id" class="form-control">
            @foreach ($tipo_curso as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-4" id="ver_curso" style="display: none">
        <label for="">Curso</label>
        <select wire:model.defer="curso_id" class="form-control">
            @foreach ($curso as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="" class="w-full">Accion</label>
        <br>
        <button type="button" class="btn btn-info">Filtrar</button>
    </div>


    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="widget-content widget-content-area br-6 table-responsive">
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
                                <button type="button" class="btn btn-danger btn-sm">Anular</button>
                                <button type="button" class="btn btn-info btn-sm">Ver recibo</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>