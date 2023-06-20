{{-- <div class="row">

    <div class="form-row">
        <div class="col-md-4 col-sm-6 mb-4">
            <label for="">Documento</label>
            <input type="text" class="form-control ">
        </div>

        <div class="col-md-4 col-sm-6 mb-4">
            <label for="">Estado Alumno</label>
            <select class="form-control">
                @foreach ($estado as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                @endforeach
            </select>
        </div>
    </div> --}}

    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive widget-content widget-content-area br-6">
            <table class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Tipo Curso</th>
                        <th>Curso</th>
                        <th>Fecha Inicio</th>
                        <th>Dias</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


{{-- </div> --}}
