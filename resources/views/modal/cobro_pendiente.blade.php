<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$titulo}}</h5>
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
                            <label for="inputPassword4">Forma Pago</label>
                            <select wire:model.defer="forma_pago_id" class="form-control">
                                @foreach ($forma_pago as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Comprobante</label>
                            <input type="file" wire:model.defer="comprobante" class="form-control" accept="image/*">
                            @error('comprobante')
                                <span role="alert" id="mensaje_2" style="color: red; padding: 2px 2px">El comprobante deber ser una imagen o pdf..</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Monto a Pagar</label>
                            <input wire:model.defer="monto_pagar" id="curso_precio" type="text" class="form-control text-right" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Total a Pagar</label>
                            <input wire:model.defer="total_pagar_modal" autofocus type="text" class="form-control text-right text-white" onkeyup="punto_decimal_limite_precio(this)" >
                            @error('total_pagar_modal')
                                <span role="alert" id="mensaje" style="color: red; padding: 2px 2px">El total a pagar no pueder estar vacio o ser 0.</span>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

</div>
