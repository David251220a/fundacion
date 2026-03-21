    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Cursos Habilitados</h2>
            </div>
            @can('habilitado.create')
                <div class="col-lg-2 col-md-10 d-flex align-items-center">
                    <a href="{{route('habilitado.create')}}" class="btn btn-info">Agregar</a>
                </div>
            @endcan

        </div>
        
        <div class="row">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Tipo Curso</label>
                        <select wire:model="tipo_curso_id" class="form-control">
                            <option value="0">-- SIN ESPECIFICAR --</option>
                            @foreach ($tipo_curso as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="curso_id">Curso</label>

                        <div class="input-group">
                            <select wire:model="curso_id" class="form-control">
                                <option value="0">-- SIN ESPECIFICAR --</option>
                                @foreach ($curso as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="curso_id">Año</label>

                        <div class="input-group">
                            <select wire:model.defer="anio" class="form-control">
                                <option value="">-- TODOS LOS AÑOS --</option>
                                @foreach ($anios as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" wire:click="filtrar" class="btn btn-primary">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="tabsLine" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area underline-content">
                        <div class="col-xl-12 col-lg-12 col-sm-12" style="">
                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id#</th>
                                        <th>Tipo Curso</th>
                                        <th>Curso</th>
                                        <th>Concluido</th>
                                        <th>Fecha Inicio</th>
                                        <th>Horario</th>
                                        <th>Dias</th>
                                        <th>Estado</th>
                                        <th class="no-content">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr style="font-weight: bold">
                                            <td class="text-right">{{$item->id}}</td>
                                            <td>
                                                {{str_pad($item->tipo_curso->id, 2, '0', STR_PAD_LEFT)}}00 -
                                                {{$item->tipo_curso->descripcion}}
                                            </td>
                                            <td>
                                                {{str_pad($item->curso->id, 3, '0', STR_PAD_LEFT)}}
                                                - {{$item->curso->descripcion }} - {{$item->curso->modulo->descripcion }}
                                            </td>
                                            <td>
                                                @if ($item->concluido)
                                                    @php
                                                        $desc = 'SI';
                                                        $estilo = 'color: green';
                                                    @endphp
                                                @else
                                                    @php
                                                        $desc = 'NO';
                                                        $estilo = 'color: red';
                                                    @endphp
                                                @endif
                                                <label for="" style="{{$estilo}}">{{$desc}}</label>
                                            </td>
                                            <td>
                                                {{date('d/m/Y', strtotime($item->periodo_desde))}}
                                            </td>
                                            <td>
                                                {{date('H:i', strtotime($item->hora_entrada))}} a {{date('H:i', strtotime($item->hora_salida))}}
                                            </td>
                                            <td>
                                                {{ ($item->lunes == 1 ? 'LUNES' : '') }}
                                                {{ ($item->martes == 1 ? 'MARTES' : '')}}
                                                {{ ($item->miercoles == 1 ? 'MIERCOLES' : '')}}
                                                {{ ($item->jueves == 1 ? 'JUEVES' : '')}}
                                                {{ ($item->viernes == 1 ? 'VIERNES' : '')}}
                                                {{ ($item->sabado == 1 ? 'SABADO' : '')}}
                                                {{ ($item->domingo == 1 ? 'DOMINGO' : '')}}
                                            </td>
                                            <td>
                                                {{$item->estado->descripcion}}
                                            </td>
                                            <td>
                                                @can('cursoAlumno.buscar')
                                                    <a href="{{route('cursoAlumno.buscar', $item)}}" class="ml-2"><i class="fas fa-user-plus"></i></a>
                                                @endcan

                                                @can('habilitado.show')
                                                    <a href="{{route('habilitado.show', $item)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                                @endcan

                                                @can('habilitado.edit')
                                                    <a href="{{route('habilitado.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div  class="col-xl-12 col-lg-12 col-sm-12">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>