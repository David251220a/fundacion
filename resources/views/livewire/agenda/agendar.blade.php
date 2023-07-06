<div class="widget-content widget-content-area rounded-pills-icon">

    <ul class="nav nav-pills justify-content-center mt-3" id="rounded-pills-icon-tab" role="tablist">
        <li class="nav-item ml-2 mr-2">
            <a class="nav-link mb-2 active text-center" id="rounded-pills-icon-home-tab" data-toggle="pill"
            href="#rounded-pills-icon-home" role="tab" aria-controls="rounded-pills-icon-home" aria-selected="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Alumnos
            </a>
        </li>

        <li class="nav-item ml-2 mr-2">
            <a class="nav-link mb-2 text-center bg-info" href="#" data-toggle="modal" data-target="#modal_buscar"
                role="tab" aria-controls="rounded-pills-icon-profile" aria-selected="false" style="color: white">
                <i class="fas fa-user-plus" style="font-size: 2.5rem"></i>
                <br>
                Agregar
            </a>
        </li>

        <li class="nav-item ml-2 mr-2">
            <a class="nav-link mb-2 text-center" href="#"
                role="tab" aria-controls="rounded-pills-icon-profile" aria-selected="false" style="background: rgb(78, 187, 87);
                color: white">
                <i class="fas fa-check" style="font-size: 2.5rem"></i>
                <br>
                habilitar
            </a>
        </li>


        <li class="nav-item ml-2 mr-2">
            <a class="nav-link mb-2 text-center" href="{{route('agenda.show', $curso->tipo_curso_id)}}"
                role="tab" aria-controls="rounded-pills-icon-profile" aria-selected="false" style="background: red;
                color: white">
                <i class="fas fa-undo" style="font-size: 2.5rem"></i>
                <br>
                Atras
            </a>
        </li>

    </ul>

    <div class="tab-content" id="rounded-pills-icon-tabContent">
        <div class="tab-pane fade show active" id="rounded-pills-icon-home" role="tabpanel" aria-labelledby="rounded-pills-icon-home-tab">
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
                                <th>Estado</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td style="text-align: right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                                    <td>{{$item->alumno->persona->nombre}}</td>
                                    <td>{{$item->alumno->persona->apellido}}</td>
                                    <td>{{$item->alumno->persona->celular}}</td>
                                    <td>{{$item->alumno->persona->email}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('modal.agenda_agregar')
    @include('modal.agenda_buscar')
    @include('modal.agenda_confirmar')
</div>
