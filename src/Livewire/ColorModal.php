<?php

namespace Awcodes\Scribble\Livewire;

use Filament\Forms\Components\ColorPicker;

class ColorModal extends ScribbleModal
{
    public ?string $header = 'Color Picker';

    public ?string $identifier = 'color';

    public function mount(): void
    {
        $this->form->fill([
            'color' => $this->data['color'] ?? 'inherit',
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ColorPicker::make('color')
                ->label('Color')
                ->columnSpanFull(),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->dispatch(
            event: 'handle-' . $this->identifier,
            statePath: $this->statePath,
            blockId: $this->blockId,
            context: $this->update ? 'update' : 'insert',
            values: $data['color'],
            coordinates: $this->coordinates
        );

        $this->closeScribbleModal();
    }
}
