<div class="form-row">
    <div class="form-group col-md-4">
        <label for="inputEmail4">Tipo de Curso</label>
        <select wire:model="tipo_curso_id" name="tipo_curso_id" id="tipo_curso_id" class="form-control" onchange="actualizar()">
            @foreach ($tipo_curso as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="inputEmail4">Curso</label>
        <select wire:model.defer="curso_id" name="curso_id" id="curso_id" class="form-control">
            @foreach ($curso as $item)
                <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->modulo->descripcion}} </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-4">
        <label for="inputPassword4">Instructor</label>
        <select name="instructor_id" id="instructor_id" class="form-control">
            @foreach ($instructor as $item)
                <option value="{{$item->id}}">{{$item->persona->nombre}} {{$item->persona->apellido}}</option>
            @endforeach
        </select>
    </div>
</div>
