<form wire:submit.prevent="save">
    <x-pounce::close-button/>

    <x-pounce::heading>
        {{ $update ? 'Update' : 'Add' }}  {{ static::getLabel() }}
    </x-pounce::heading>

    <x-filament::hr/>

    <x-pounce::content>
        {{ $this->form }}
    </x-pounce::content>

    <x-pounce::footer>
        <x-filament::button type="submit">
            {{ $update ? 'Update' : 'Insert' }} block
        </x-filament::button>
        <x-filament::button color="secondary" wire:click="unPounce">
            Cancel
        </x-filament::button>
    </x-pounce::footer>
</form>
