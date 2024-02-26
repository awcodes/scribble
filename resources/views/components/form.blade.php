<form wire:submit.prevent="save">
    <x-pounce::close-button/>

    <x-pounce::header>
        {{ ($update ? trans('scribble::modal.update') : trans('scribble::modal.insert')) . ' ' . $header }}
    </x-pounce::header>

    <x-pounce::content>
        {{ $this->form }}
    </x-pounce::content>

    <x-pounce::footer>
        <x-filament::button type="submit">
            {{ $update ? trans('scribble::modal.update') : trans('scribble::modal.insert') }}
        </x-filament::button>
        <x-filament::button color="gray" wire:click="unPounce">
            {{ trans('scribble::modal.cancel') }}
        </x-filament::button>
    </x-pounce::footer>
</form>
