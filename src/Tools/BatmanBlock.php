<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Concerns\InteractsWithMedia;
use Filament\Forms;

class BatmanBlock extends ScribbleTool
{
    use InteractsWithMedia;

    protected static string $icon = 'heroicon-o-cube';

    protected static string $label = 'Batman Character';

    protected static bool $shouldShowInSuggestionMenu = true;

    protected static string $view = 'scribble::actions.batman';

    public ?string $statePath = null;

    public ?string $name = null;

    public ?string $color = null;

    public ?string $side = null;

    public static function getType(): string
    {
        return static::BLOCK;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Large;
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->name,
            'color' => $this->color,
            'side' => $this->side,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('color'),
                Forms\Components\Select::make('side')
                    ->options([
                        'Hero' => 'Hero',
                        'Villain' => 'Villain',
                    ])
                    ->default('Hero')
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        $this->dispatch(
            event: $event . '-' . static::getExtension(),
            statePath: $this->statePath,
            data: $data,
        );

        $this->unPounce();
    }
}
