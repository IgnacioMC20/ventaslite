

@include('comon.modalHead')

<div class="row">
    

        <div class="col-sm-12 col-md-8">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingresa el nombre">
                @error('name')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Código</label>
                <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="Ingresa el codigo">
                @error('barcode')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Costo</label>
                <input type="text" wire:model.lazy="cost" data-tyoe="currency" class="form-control" placeholder="Ingresa el costo">
                @error('cost')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Precio</label>
                <input type="text" wire:model.lazy="price" data-tyoe="currency" class="form-control" placeholder="Ingresa el precio">
                @error('precio')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Stock</label>
                <input type="text" wire:model.lazy="stock" class="form-control" placeholder="Ingresa el stock">
                @error('stock')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Alertas</label>
                <input type="number" wire:model.lazy="alerts" class="form-control" placeholder="Ingresa la cantidad para las alertas">
                @error('alerts')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Categoría</label>
                <select class="form-control" wire:model="category_id">
                    <option value="" disabled>Escoge una opcion...</option>
                    <option value="" disabled></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="form-group custom-file">
                <input type="file" class="custom-file-input" wire:model='image' accept="image/x-png, image/gif, image/jepg">
                <label class="custom-file-label">Imagen {{ $image }}</label>
                @error('image')
                    <span class="text-danger err">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-8">
            <div class="form-group custom-file">
                <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg"> 
            </div>
        </div>

</div>
@include('comon.modalFooter')