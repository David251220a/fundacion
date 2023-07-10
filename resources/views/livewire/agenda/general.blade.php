<div>
    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Familia</label>
                            <select wire:model.defer="familia_id" class="form-control" onchange="cargar_curso()">
                                @foreach ($familia as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Curso</label>
                            <select wire:model.defer="curso_id" class="form-control">
                                @foreach ($curso as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->modulo->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="w-full">Acción</label>
                            <br>
                            <button type="button" wire:click="carga_datos()" class="btn btn-info mr-2">Filtrar</button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_buscar">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget-content widget-content-area br-6 table-responsive">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th class="text-center no-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td style="text-align: right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                                <td style="text-align: ">{{$item->alumno->persona->nombre}}</td>
                                <td style="text-align: ">{{$item->alumno->persona->apellido}}</td>
                                <td style="text-align: ">{{$item->alumno->persona->celular}}</td>
                                <td style="text-align: ">{{$item->alumno->persona->email}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminar({{$item->id}})">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <td colspan="6" class="text-white" style="font-size: 18px">
                            <b> Cantidad agendado: {{count($data)}}</b>
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    @include('modal.agenda_buscar')
    @include('modal.agenda_agregar')
    @include('modal.agenda_confirmar_general')
</div>
