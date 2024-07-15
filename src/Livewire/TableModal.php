<?php

namespace Awcodes\Scribble\Livewire;

use Filament\Forms;
use Illuminate\Contracts\View\View;

class TableModal extends ScribbleModal
{
    public ?string $header = 'Table';

    public function mount(): void
    {
        $this->form->fill([
            'rows' => 2,
            'cols' => 3,
            'withHeaderRow' => true,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            Forms\Components\TextInput::make('rows')
                ->label('Rows')
                ->numeric()
                ->required()
                ->dehydrateStateUsing(function (Forms\Get $get, $state) {
                    if ($get('withHeaderRow')) {
                        return $state + 1;
                    }

                    return $state;
                }),
            Forms\Components\TextInput::make('cols')
                ->label('Columns')
                ->numeric()
                ->required(),
            Forms\Components\Checkbox::make('withHeaderRow'),
        ];
    }
}
