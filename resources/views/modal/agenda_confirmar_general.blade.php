<div wire:ignore.self class="modal fade bd-example" id="modal_confirmar_general" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Alumno - Agenda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="" class="col-lg-12">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Nombre y Apellido</label>
                            @php
                                $nom =  $documento . ' - ' . $nombre . ' ' . $apellido;
                            @endphp
                            <input type="text" class="form-control text-right" value="{{$nom}}">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputPassword4">Familia</label>
                        <select wire:model.self="modal_familia_id" class="form-control" onchange="modal_cargar_curso()">
                            @foreach ($modal_familia as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputPassword4">Curso</label>
                        <select wire:model.self="modal_curso_id" class="form-control">
                            @foreach ($modal_curso as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->modulo->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputPassword4">Celular</label>
                        <input type="text" wire:model.defer="celular" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputPassword4">Email</label>
                        <input type="email" wire:model.defer="email" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="confirmar" type="button" class="btn btn-success">Confirmar</button>
            </div>
        </div>
    </div>

</div>
