<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Scribble\ScribbleTool;
use Filament\Forms;

class Link extends ScribbleTool
{
    protected static string $icon = 'scribble-link';

    protected static string $label = 'Link';

    protected static bool $shouldShowInBubbleMenu = true;

    public ?string $href = null;

    public ?string $link_id = null;

    public ?string $hreflang = null;

    public ?string $target = null;

    public ?string $rel = null;

    public ?string $referrerpolicy = null;

    public ?string $as_button = null;

    public ?string $button_theme = null;

    public static function getType(): string
    {
        return static::MODAL;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Large;
    }

    public function mount(): void
    {
        $this->form->fill([
            'href' => $this->href,
            'id' => $this->link_id,
            'hreflang' => $this->hreflang,
            'target' => $this->target,
            'rel' => $this->rel,
            'referrerpolicy' => $this->referrerpolicy,
            'as_button' => $this->as_button,
            'button_theme' => $this->button_theme,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Grid::make(['md' => 3])
                    ->schema([
                        Forms\Components\TextInput::make('href')
                            ->label(trans('scribble::link.modal.labels.url'))
                            ->columnSpan('full')
                            ->requiredWithout('id')
                            ->validationAttribute('URL'),
                        Forms\Components\TextInput::make('id'),
                        Forms\Components\Select::make('target')
                            ->selectablePlaceholder(false)
                            ->options([
                                '' => trans('scribble::link.modal.labels.target.default'),
                                '_blank' => trans('scribble::link.modal.labels.target.new_window'),
                                '_parent' => trans('scribble::link.modal.labels.target.parent'),
                                '_top' => trans('scribble::link.modal.labels.target.top'),
                            ]),
                        Forms\Components\TextInput::make('hreflang')
                            ->label(trans('scribble::link.modal.labels.language')),
                        Forms\Components\TextInput::make('rel')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('referrerpolicy')
                            ->label(trans('scribble::link.modal.labels.referrer_policy'))
                            ->columnSpan('full'),
                        Forms\Components\Toggle::make('as_button')
                            ->label(trans('scribble::link.modal.labels.as_button'))
                            ->reactive(),
                        Forms\Components\Radio::make('button_theme')
                            ->columnSpan('full')
                            ->columns(2)
                            ->visible(fn (Forms\Get $get) => $get('as_button'))
                            ->options([
                                'primary' => trans('scribble::link.modal.labels.button_theme.primary'),
                                'secondary' => trans('scribble::link.modal.labels.button_theme.secondary'),
                                'tertiary' => trans('scribble::link.modal.labels.button_theme.tertiary'),
                                'accent' => trans('scribble::link.modal.labels.button_theme.accent'),
                            ]),
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
            data: $data
        );

        $this->unPounce();
    }
}
