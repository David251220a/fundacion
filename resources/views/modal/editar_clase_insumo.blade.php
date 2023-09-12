<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_insumo_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Editar Insumo</h5>
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
                            <label for="inputEmail4">Insumo</label>
                            <select wire:model.defer="editar_insumo_id" class="form-control">
                                @foreach ($insumos as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Descripcion</label>
                            <input type="text" wire:model.defer="editar_descripcion" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Precio</label>
                            <input type="text" wire:model.defer="editar_precio" class="form-control text-right" onkeyup="punto_decimal(this)">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Fecha</label>
                            <input type="date" wire:model.defer="editar_fecha" class="form-control" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Estado</label>
                            <select wire:model.defer="editar_estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="update({{$editar_id}})" type="button"  wire:loading.attr="disabled" class="btn btn-primary">Editar</button>
            </div>
        </div>
    </div>

</div>
