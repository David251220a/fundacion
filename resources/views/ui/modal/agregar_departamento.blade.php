<div wire:ignore.self class="modal fade" id="deparmodal" tabindex="-1" role="dialog" aria-labelledby="deparmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deparmodal">Crear Departamento</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mb-4">
                    <label for="">Pais</label>
                    {{-- <label for="">{{$nombre_pais}}</label> --}}
                    <input class="form-control" value="{{$nombre_pais}}" readonly>
                </div>
                <div class="col-md-12">
                    <label for="descripcion_departamento">Nombre Departamento</label>
                    <input type="text" wire:model.defer="descripcion_departamento" class="form-control" placeholder="Nombre Departamento">
                    <span id="mensaje_departamento" style="display: none">
                        <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert" id="contenido_departamento">

                        </div>
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save_departamento" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
