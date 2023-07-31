<div class="modal fade bd-example-modal-lg" id="modal_concepto_agregar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Ingreso Concepto</h5>
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
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Descripcion</label>
                            <input wire:model.defer="descripcion_concepto" type="text" class="form-control" placeholder="Descripcion">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Precio</label>
                            <input wire:model.defer="precio_concepto" type="text" class="form-control text-right" onkeyup="punto_decimal_limite(this)">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" type="button" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="agregar_concepto" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
