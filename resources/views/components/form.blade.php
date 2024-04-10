<div>
    <form wire:submit.prevent="save">
        <x-scribble::modals.close-button/>

        <x-scribble::modals.header>
            {{ ($update ? trans('scribble::modal.update') : trans('scribble::modal.insert')) . ' ' . $header }}
        </x-scribble::modals.header>

        <x-scribble::modals.content>
            {{ $this->form }}
        </x-scribble::modals.content>

        <x-scribble::modals.footer>
            <x-filament::button type="submit">
                {{ $update ? trans('scribble::modal.update') : trans('scribble::modal.insert') }}
            </x-filament::button>
            <x-filament::button color="gray" wire:click="closeScribbleModal">
                {{ trans('scribble::modal.cancel') }}
            </x-filament::button>
        </x-scribble::modals.footer>
    </form>
    <x-filament-actions::modals />
</div>
