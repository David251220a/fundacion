<div class="form-row">
    <div class="form-group col-md-3">
        <label for="inputEmail4">Tipo de Curso</label>
        <select wire:model.defer="tipo_curso_id" name="tipo_curso_id" id="tipo_curso_id" class="form-control basic">
            @foreach ($tipo_curso as $item)
                <option {{ (old('tipo_curso')== $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="inputEmail4">Curso</label>
        <select wire:model.defer="curso_id" name="curso_id" id="curso_id" class="form-control basic-2">
            @foreach ($curso as $item)
                <option {{ (old('curso_id')== $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="inputPassword4">Precio</label>
        <input type="text" name="precio" id="precio" class="form-control text-right" onkeyup="punto_decimal_limite(this)" value="{{old('precio')}}">
    </div>
    <div class="form-group col-md-3">
        <label for="inputPassword4">Instructor</label>
        <select name="instructor_id" id="instructor_id" class="form-control">
            @foreach ($instructor as $item)
                <option value="{{$item->id}}">{{$item->persona->nombre}} {{$item->persona->apellido}}</option>
            @endforeach
        </select>
    </div>
</div>
