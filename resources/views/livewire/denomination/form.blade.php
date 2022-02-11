@include('comon.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Tipo</label>
            <select wire:model="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('type')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group">
            <label for="">Value</label>
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input type="number" name="" id="" class="form-control" placeholder="Valor" wire:model.lazy="value">
        </div>
        @error('value')
            <span class="text-danger er"> {{ $message }} </span>
        @enderror
    </div>
    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" name="" id="" class="custom-file-input" wire:model='image' accept="image/x-png, image/gif, image/jepg">
            <label class="custom-file-label">Imagen {{ $image }}</label>
            @error('image')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

@include('comon.modalFooter')