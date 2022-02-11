<div>
    <div class="row sales layout-top-spacing mx-4">

        <div class="col-sm-12 mx-5">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <p>{{ $componentName }} | {{ $pageTitle }}</p>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                                data-target="#themodal">Agregar</a>
                        </li>
                    </ul>
                </div>

                @include('comon.searchbox')

                <div class="widget-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background-color: #3B3F5C;">
                                <tr>
                                    <th class="table-th text-white">Tipo</th>
                                    <th class="table-th text-white">Imagen</th>
                                    <th class="table-th text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coins as $coin)

                                    <tr>
                                        <td>
                                            <h6>{{ $coin->type }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ number_format($coin->value, 2) }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <span>
                                                <img src="{{ asset('storage/denominations/' . $coin->image) }}"
                                                    alt="Imagen de Ejemplo" height="70" width="80"
                                                    class="rounded">
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="edit({{ $coin->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </a>

                                            <a href="javascript:void(0)" onclick="Confirmjavascript('{{ $coin->id }}')"
                                                class="btn btn-dark mtmobile" title="Delete">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $coins->links() }}
                    </div>

                </div>
            </div>
        </div>

        @include('livewire.denomination.form')

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
              window.livewire.on('denomination-added', msg => {
                  $('#themodal').modal('hide');
                  noty(msg);
              })
              window.livewire.on('denomination-updated', msg => {
                  $('#themodal').modal('hide');
                //   noty(msg);
                  Swal.fire(
                    'Genial!',
                    `${msg}`,
                    'success'
                  )
              })
              window.livewire.on('denomiation-deleted', msg => {
                  noty(msg);
              })
            //   window.livewire.on('hide-modal', msg => {
            //       $('#themodal').modal('hide');
            //   })
            window.livewire.on('show-modal', msg => {
                $('#themodal').modal('show');
            })
            //   window.livewire.on('hidden.bs.modal', msg => {
            //       $('.er').css('display', 'none');
            //   })
        });

        function Confirmjavascript(id) {
            Swal.fire({
                title: 'Confirmar',
                text: 'Confirmas eliminar?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3B3F5C',
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('deleteRow', id)
                    Swal.close()
                }
            })
        }
    </script>
</div>
