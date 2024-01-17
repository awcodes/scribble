<form wire:submit.prevent="action" class="p-2 space-y-2 bg-white cursor-default pointer-events-auto dark:bg-gray-900">
    <x-forms::modal.heading class="px-4 py-2">
        {{ $update ? 'Update' : 'Add' }}  {{ static::getTitle() }}
    </x-forms::modal.heading>

    <x-filament::hr/>

    <div class="px-2 py-4">
        {{ $this->form }}
    </div>

    <x-filament::hr/>

    <x-filament::modal.actions alignment="right" class="p-2">
        <x-filament::button type="submit">
            {{ $update ? 'Update' : 'Insert' }} block
        </x-filament::button>
        <x-filament::button color="secondary" wire:click="closeModal">
            Cancel
        </x-filament::button>
    </x-filament::modal.actions>
</form>
