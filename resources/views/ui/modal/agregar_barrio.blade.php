<div wire:ignore.self class="modal fade" id="ciudadbarrio" tabindex="-1" role="dialog" aria-labelledby="ciudadbarrio" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ciudadbarrio">Crear Ciudad</h5>
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
                <div class="col-md-12 mb-4">
                    <label for="descripcion_pais">Ciudad</label>
                    <input class="form-control" value="{{$nombre_ciudad}}" readonly>
                </div>
                <div class="col-md-12">
                    <label for="descripcion_barrio">Nombre Barrio</label>
                    <input type="text" wire:model.defer="descripcion_barrio" class="form-control" placeholder="Nombre Barrio">
                    <span id="mensaje_barrio" style="display: none">
                        <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert" id="contenido_barrio">

                        </div>
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save_barrio" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
