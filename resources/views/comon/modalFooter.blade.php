            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-white" wire:click.prevent="resetUI()" data-dismiss="modal">Cerrar</button>
                
                @if ($selected_id < 1)
                <button type="button" class="btn btn-dark text-white close-modal" wire:click.prevent="Store()">Guardar</button>
                @else
                <button type="button" class="btn btn-dark text-white close-modal" wire:click.prevent="Update()">Actualizar</button>
                @endif
            </div>
        </div>
    </div>
</div>
