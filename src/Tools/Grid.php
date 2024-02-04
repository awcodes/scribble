<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;
use Filament\Forms;
use Illuminate\Contracts\View\View;

class Grid extends ScribbleTool
{
    protected string $icon = 'scribble-grid';

    protected string $label = 'Grid';

    public ?string $columns = '2';

    public ?string $stack_at = null;

    public ?bool $asymmetric = null;

    public ?int $left_span = null;

    public ?int $right_span = null;

    public function getType(): ToolType
    {
        return ToolType::Modal;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getCommands(): ?array
    {
        return [
            ['command' => 'insertGrid', 'arguments' => null],
        ];
    }

    public function mount(): void
    {
        $this->form->fill([
            'columns' => $this->columns,
            'stack_at' => $this->stack_at,
            'asymmetric' => $this->asymmetric,
            'left_span' => $this->left_span,
            'right_span' => $this->right_span,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('columns')
                            ->label(trans('scribble::grid.labels.columns'))
                            ->required()
                            ->default(2)
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
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        $this->dispatch(
            event: $event . '-' . static::getExtension(),
            statePath: $this->statePath,
            values: $data,
        );

        $this->unPounce();
    }

    public function render(): View
    {
        return view('scribble::components.grid-form');
    }
}
