<div class="layout-px-spacing mt-4">

    <div class="row layout-spacing">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="w-25 p-3">Familia</h2>
        </div>
        @can('tipocurso.create')
            <div class="col-lg-2 col-md-10 d-flex align-items-center">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg">Agregar</button>
            </div>
        @endcan

    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr style="font-weight: bold">
                            <td>{{$item->id}}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>
                                @if ($item->estado_id == 1)
                                   <a class="btn-si">Activo</a>
                                @else
                                    <a class="btn-no">Inactivo</a>
                                @endif
                            </td>
                            <td>
                                {{$item->usuario->name}}
                            </td>
                            <td>
                                @can('tipocurso.edit')
                                    <a onclick="edicion({{$item->id}})" class="ml-2"><i class="fas fa-pencil"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('modal.tipocurso-add')
    @include('modal.tipocurso-edit')
</div>
