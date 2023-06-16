<div wire:ignore.self class="modal fade" id="ciudadmodal" tabindex="-1" role="dialog" aria-labelledby="ciudadmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ciudadmodal">Crear Ciudad</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mb-4">
                    <label for="descripcion_pais">Pais</label>
                    <input class="form-control" value="{{$nombre_pais}}" readonly>
                </div>
                <div class="col-md-12 mb-4">
                    <label for="descripcion_pais">Departamento</label>
                    <input class="form-control" value="{{$nombre_departamento}}" readonly>
                </div>
                <div class="col-md-12">
                    <label for="descripcion_ciudad">Nombre Ciudad</label>
                    <input type="text" wire:model.defer="descripcion_ciudad" class="form-control" placeholder="Nombre Ciudad">
                    <span id="mensaje_ciudad" style="display: none">
                        <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert" id="contenido_ciudad">

                        </div>
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save_ciudad" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
