<div>
    <div class="row sales layout-top-spacing">

        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <p>{{ $componentName }} | {{ $pageTitle }}</p>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#themodal">Agregar</a>
                        </li>
                    </ul>
                </div>
                @include('comon.searchbox')
    
                <div class="widget-content">
    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background-color: #3B3F5C;">
                                <tr>
                                    <th class="table-th text-white text-center">Descripcion</th>
                                    <th class="table-th text-white text-center">Barcode</th>
                                    <th class="table-th text-white text-center">Categoria</th>
                                    <th class="table-th text-white text-center">Precio</th>
                                    <th class="table-th text-white text-center">Stock</th>
                                    <th class="table-th text-white text-center">Inv. Minimo</th>
                                    <th class="table-th text-white text-center">Imagen</th>
                                    <th class="table-th text-white text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center"><h6>{{ $product->name }}</h6></td>
                                        <td class="text-center"><h6>{{ $product->barcode }}</h6></td>
                                        <td class="text-center"><h6>{{ $product->category }}</h6></td>
                                        <td class="text-center"><h6>{{ $product->price }}</h6></td>
                                        <td class="text-center"><h6>{{ $product->stock }}</h6></td>
                                        <td class="text-center"><h6>{{ $product->alerts }}</h6></td>
                                        <td class="text-center">
                                            <span>
                                                <img src="{{ asset('/storage/products/'. $product->image) }}" alt="Imagen de Ejemplo" height="70" width="80" class="rounded">
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click.prevent="editarProducto({{ $product->id }})" title="Edit">
                                                // ? Icono editar
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-dark mtmobile" onclick="borrarProducto(' {{ $product->id }} ')" title="Edit">
                                                // ? Icono trash
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
    
                </div>
            </div>
        </div>
        @include('livewire.products.form')
    </div>
    
    <script>
         document.addEventListener('DOMContentLoaded', () => {
            window.livewire.on('category-added', msg => {
                $('#themodal').modal('hide');
                Swal.fire(
                'Genial!',
                `${msg}`,
                'success'
                )
            });

            window.livewire.on('product-updated', msg => {
                $('#themodal').modal('hide');
            //   noty(msg);
                Swal.fire(
                'Genial!',
                `${msg}`,
                'success'
                )
            });

            window.livewire.on('product-deleted', msg => {
                $('#themodal').modal('hide');
            Swal.fire(
                ':(',
                `${msg}`,
                'danger'
                )
            });

            window.livewire.on('hide-modal', msg => {
                $('#themodal').modal('hide');
            });

            window.livewire.on('show-modal', msg => {
                $('#themodal').modal('show');
            });

            window.livewire.on('hidden.bs.modal', msg => {
                $('.er').css('display', 'none');
            });
        });

        function borrarProducto(id) {
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
