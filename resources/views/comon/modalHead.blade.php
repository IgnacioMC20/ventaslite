<div wire:ignore.self class="modal fade" id="themodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white">
              <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'Editar' : 'Crear' }}
          </h5>
          <h6 class="text-center text-warning" wire:loading>Por Favor espere</h6>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">