<div wire:ignore.self class="modal fade" id="paismodal" tabindex="-1" role="dialog" aria-labelledby="paismodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Crear Pais</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="descripcion_pais">Nombre Pais</label>
                    <input type="text" wire:model.defer="descripcion_pais" class="form-control" placeholder="Nombre Pais">
                    @error('descripcion_pais')
                        <span id="mensaje">
                            <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                {{$message}}
                            </div>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" type="button" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
