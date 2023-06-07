<div wire:ignore.self class="modal fade bd-example-modal-lg editar-tipocurso" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Editar Tipo Curso: {{$descripcion}}</h5>
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
                            <input wire:model.defer="descripcion" type="text" class="form-control" placeholder="Descripcion" value="{{$descripcion}}">
                            @error('descripcion')
                                <span role="alert" id="mensaje" style="color: red; padding: 2px 2px">Por favor complete este campo.</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Estado</label>
                            <select wire:model.defer="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="actualizar({{$tipo_id}})" type="button" class="btn btn-primary">Editar</button>
            </div>
        </div>
    </div>
</div>
