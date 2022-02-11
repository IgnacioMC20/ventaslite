<div>
    <style>

    </style>

    <div class="row layout-top-spacing w-100 ml-5">
        <div class="col-sm-12 col-md-8">
            {{-- Detalles --}}
            @include('livewire.pos.partials.detail')
        </div>

        <div class="col-sm-12 col-md-4">
            {{-- Total --}}
            @include('livewire.pos.partials.total')

            {{-- Denominations --}}
            @include('livewire.pos.partials.coins')
        </div>
    </div>
    <script src="{{ asset('js/keypress.js') }}"></script>
    <script src="{{ asset('js/onscan.js') }}"></script>
</div>
