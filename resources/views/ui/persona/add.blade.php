<div class="form-row">

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Documento</label>
        @php
            if(empty($documento)){
                $doc = '';
            }else {
                $doc = number_format($documento, 0, ".", ".");
            }
        @endphp
        <input type="text" name="documento" id="documento" class="form-control text-right" placeholder="Documento"
        value="{{old('documento', $doc)}}" onkeyup="punto_decimal(this)" required>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre..." value="{{old('nombre')}}" required>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Apellido</label>
        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido..." value="{{old('apellido')}}" required>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Fecha Nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{old('fecha_nacimiento')}}">
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Sexo</label>
        <select name="sexo" id="sexo" class="form-control">
            <option value="0">SIN ESPECIFICAR</option>
            <option value="1">MASCULINO</option>
            <option value="2">FEMENINO</option>
        </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Celular</label>
        <input type="text" name="celular" id="celular" class="form-control">
    </div>

    <div class="col-md-6 col-sm-6 mb-4">
        <label for="">Direccion</label>
        <input type="text" name="direccion" id="direccion" class="form-control">
    </div>

</div>

@livewire('persona.create-persona')

<div class="form-row">

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Email</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Estado Civil</label>
        <select name="estado_civil_id" id="estado_civil_id" class="form-control">
            @foreach ($estado_civil as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    {{-- <div class="col-md-3 col-sm-6 mb-4">
        <label for="">P</label>
        <select name="partido_id" id="partido_id" class="form-control">
            @foreach ($partido as $item)
                <option value="{{$item->id}}">{{$item->alias}}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Estado</label>
        <select name="estado_id" id="estado_id" class="form-control">
            <option value="1">ACTIVO</option>
            <option value="2">INACTIVO</option>
        </select>
    </div>
</div>

<h2>Familiares</h2>

<div class="form-row">

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Nombre</label>
        <input type="text" id="f_nombre" class="form-control" placeholder="Nombre...">
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Apellido</label>
        <input type="text" id="f_apellido" class="form-control" placeholder="apellido...">
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Tipo Familiar</label>
        <select id="tipo_familia" class="form-control">
            @foreach ($tipo_familia as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-1 col-sm-2 mb-4">
        <label for="">P</label>
        <select id="partido" class="form-control">
            <option value="1">S</option>
            {{-- @foreach ($partido as $item)
                <option value="{{$item->id}}">{{$item->alias}}</option>
            @endforeach --}}
        </select>
    </div>

    <div class="col-md-1 col-sm-2 mb-4">
        <label for="">Accion</label>
        <button type="button" class="btn btn-primary btn-lg" onclick="agregar_datos()">Agregar</button>
    </div>

</div>

<div class="col-xl-12 col-lg-12 col-sm-12">
    <div class="table-responsive widget-content widget-content-area br-6">
        <table class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo Familia</th>
                    <th>P</th>
                    <th class="no-content">Actions</th>
                </tr>
            </thead>
            <tbody id="datos_familia">
            </tbody>
        </table>
    </div>
</div>
