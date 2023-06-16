<div wire:ignore.self class="modal fade bd-example-modal-xl" id="personamodal" tabindex="-1" role="dialog" aria-labelledby="personamodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Crear Persona</h5>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Documento</label>
                        <input wire:model.defer="documento" type="text" class="form-control" placeholder="Documento">
                        @error('documento')
                            <span id="mensaje_1">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Nombre</label>
                        <input wire:model.defer="nombre" type="text" class="form-control">
                        @error('nombre')
                            <span id="mensaje_2">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Apellido</label>
                        <input wire:model.defer="apellido" type="text" class="form-control">
                        @error('apellido')
                            <span id="mensaje_3">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Sexo</label>
                        <select wire:model.defer="sexo" name="sexo" id="sexo" class="form-control">
                            <option value="0">SIN ESPECIFICAR</option>
                            <option value="1">MASCULINO</option>
                            <option value="2">FEMENINO</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Fecha de Nacimiento</label>
                        <input wire:model.defer="fecha_nacimiento" type="date" class="form-control">
                        @error('fecha_nacimiento')
                            <span id="mensaje_4">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-5 col-sm-6 mb-4">
                        <label for="">Dirección</label>
                        <input wire:model.defer="direccion" type="text" class="form-control">
                        @error('direccion')
                            <span id="mensaje_5">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-4 col-sm-3 mb-4">
                        <label for="">Barrio</label>
                        <input wire:model.defer="barrio" type="text" class="form-control">
                        @error('barrio')
                            <span id="mensaje_6">
                                <div class="alert alert-light-danger border-0 mb-4 mt-2" role="alert">
                                    Por favor complete este campo
                                </div>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 col-sm-6 mb-4">
                        <label for="">Celular</label>
                        <input wire:model.defer="celular" type="text" class="form-control" placeholder="Celular">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" type="button" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button onclick="save()" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
