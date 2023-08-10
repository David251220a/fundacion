            <div class="modal-footer">
                <button wire:click="resetUI()" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                @if ($codigo == 0)
                    <button wire:click="save()" type="button" class="btn btn-primary">Guardar</button>
                @endif

                @if ($codigo == 1)
                    <button wire:click="update()" type="button" class="btn btn-primary">Editar</button>
                @endif
            </div>
        </div>
    </div>
</div>
