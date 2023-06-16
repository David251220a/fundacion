<div class="form-row">
    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Pais - <button type="button" data-toggle="modal" data-target="#paismodal" style="border-radius: 15px">Crear</button></label>
        <select wire:model="pais_id" name="pais_id" class="form-control " onchange="actualizar_pais()">
            @foreach ($pais as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Departamento - <button type="button" data-toggle="modal" data-target="#deparmodal" style="border-radius: 15px">Crear</button></label>
        <select wire:model="departamento_id" name="departamento_id" class="form-control " onchange="actualizar_departamento()">
            @foreach ($departamento as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Ciudad - <button type="button" data-toggle="modal" data-target="#ciudadmodal" style="border-radius: 15px">Crear</button></label>
        <select wire:model="ciudad_id" name="ciudad_id" class="form-control ">
            @foreach ($ciudad as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <label for="">Barrio - <button type="button" data-toggle="modal" data-target="#ciudadbarrio" style="border-radius: 15px">Crear</button></label>
        <select wire:model="barrio_id" name="barrio_id" class="form-control ">
            @foreach ($barrio as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

    @include('ui.modal.agregar_pais')
    @include('ui.modal.agregar_departamento')
    @include('ui.modal.agregar_ciudad')
    @include('ui.modal.agregar_barrio')
</div>
