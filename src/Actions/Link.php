<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;
use Filament\Forms;

class Link extends ScribbleAction
{
    protected static string $icon = 'scribble-link';

    protected static string $label = 'Link';

    public static function getType(): string
    {
        return static::INLINE;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(['md' => 3])
                    ->schema([
                        Forms\Components\TextInput::make('href')
                            ->label(trans('filament-tiptap-editor::link-modal.labels.url'))
                            ->columnSpan('full')
                            ->requiredWithout('id')
                            ->validationAttribute('URL'),
                        Forms\Components\TextInput::make('id'),
                        Forms\Components\Select::make('target')
                            ->selectablePlaceholder(false)
                            ->options([
                                '' => trans('filament-tiptap-editor::link-modal.labels.target.default'),
                                '_blank' => trans('filament-tiptap-editor::link-modal.labels.target.new_window'),
                                '_parent' => trans('filament-tiptap-editor::link-modal.labels.target.parent'),
                                '_top' => trans('filament-tiptap-editor::link-modal.labels.target.top'),
                            ]),
                        Forms\Components\TextInput::make('hreflang')
                            ->label(trans('filament-tiptap-editor::link-modal.labels.language')),
                        Forms\Components\TextInput::make('rel')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('referrerpolicy')
                            ->label(trans('filament-tiptap-editor::link-modal.labels.referrer_policy'))
                            ->columnSpan('full'),
                        Forms\Components\Toggle::make('as_button')
                            ->label(trans('filament-tiptap-editor::link-modal.labels.as_button'))
                            ->reactive(),
                        Forms\Components\Radio::make('button_theme')
                            ->columnSpan('full')
                            ->columns(2)
                            ->visible(fn (Forms\Get $get) => $get('as_button'))
                            ->options([
                                'primary' => trans('filament-tiptap-editor::link-modal.labels.button_theme.primary'),
                                'secondary' => trans('filament-tiptap-editor::link-modal.labels.button_theme.secondary'),
                                'tertiary' => trans('filament-tiptap-editor::link-modal.labels.button_theme.tertiary'),
                                'accent' => trans('filament-tiptap-editor::link-modal.labels.button_theme.accent'),
                            ]),
                    ])
            ]);
    }
}
