<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_empleado_agregar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$titulo_dos}}</h5>
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
                            <label for="inputPassword4">Documento</label>
                            <input type="text" wire:model.defer="documento" class="form-control text-right" onkeyup="punto_decimal(this)" {{( empty($documento) ? '' : 'readonly' )}}>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Nombre</label>
                            <input type="text" wire:model.defer="nombre" class="form-control"  {{( empty($persona) ? '' : 'readonly' )}}>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Apellido</label>
                            <input type="text" wire:model.defer="apellido" class="form-control" {{( empty($persona) ? '' : 'readonly' )}}>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Celular</label>
                            <input type="text" wire:model.defer="celular" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Email</label>
                            <input type="text" wire:model.defer="email" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Remuneración</label>
                            <input type="text" wire:model.defer="remuneracion" class="form-control text-right" onkeyup="punto_decimal(this)">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Forma de Cobro</label>
                            <select wire:model.defer="salario_pago_id" class="form-control">
                                @foreach ($salario_pago as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save_empleado" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

</div>
