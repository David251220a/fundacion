<div class="modal fade bd-example" id="modal_buscar_{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Opciones</h5>
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
                            <a href="{{route('habilitado.show', $item)}}" class="btn btn-info">Inscribir</a>
                        </div>

                        <div class="form-group col-md-6">
                            <a href="{{route('agenda.agenda', $item->curso_id)}}" class="btn btn-info">Agendar</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
