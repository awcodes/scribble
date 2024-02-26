<?php

namespace Awcodes\Scribble\Livewire;

use Filament\Forms;
use Illuminate\Contracts\View\View;

class GridModal extends ScribbleModal
{
    public ?string $header = 'Grid';

    public function mount(): void
    {
        $this->form->fill([
            'columns' => 2,
            'stack_at' => 'md',
            'asymmetric' => false,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('columns')
                        ->label(trans('scribble::grid.labels.columns'))
                        ->required()
                        ->live()
                        ->minValue(2)
                        ->maxValue(12)
                        ->numeric()
                        ->step(1),
                    Forms\Components\Select::make('stack_at')
                        ->label(trans('scribble::grid.labels.stack_at'))
                        ->live()
                        ->selectablePlaceholder(false)
                        ->options([
                            'none' => trans('scribble::grid.labels.dont_stack'),
                            'sm' => 'sm',
                            'md' => 'md',
                            'lg' => 'lg',
                        ])
                        ->default('md'),
                    Forms\Components\Toggle::make('asymmetric')
                        ->label(trans('scribble::grid.labels.asymmetric'))
                        ->default(false)
                        ->live()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('left_span')
                        ->label(trans('scribble::grid.labels.asymmetric_left'))
                        ->required()
                        ->live()
                        ->minValue(1)
                        ->maxValue(12)
                        ->numeric()
                        ->visible(fn (Forms\Get $get) => $get('asymmetric')),
                    Forms\Components\TextInput::make('right_span')
                        ->label(trans('scribble::grid.labels.asymmetric_right'))
                        ->required()
                        ->live()
                        ->minValue(1)
                        ->maxValue(12)
                        ->numeric()
                        ->visible(fn (Forms\Get $get) => $get('asymmetric')),
                ]),
        ];
    }

    public function render(): View
    {
        return view('scribble::components.grid-form');
    }
}
