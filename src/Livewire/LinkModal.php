<?php

namespace Awcodes\Scribble\Livewire;

use Filament\Forms;

class LinkModal extends ScribbleModal
{
    public ?string $header = 'Link';

    public function getFormFields(): array
    {
        return [
            Forms\Components\Grid::make(['md' => 3])
                ->schema([
                    Forms\Components\TextInput::make('href')
                        ->label(trans('scribble::link.labels.url'))
                        ->columnSpan('full')
                        ->requiredWithout('id')
                        ->validationAttribute('URL'),
                    Forms\Components\TextInput::make('id')
                        ->label(trans('scribble::link.labels.id')),
                    Forms\Components\Select::make('target')
                        ->selectablePlaceholder(false)
                        ->options([
                            '' => trans('scribble::link.labels.target.default'),
                            '_blank' => trans('scribble::link.labels.target.new_window'),
                            '_parent' => trans('scribble::link.labels.target.parent'),
                            '_top' => trans('scribble::link.labels.target.top'),
                        ]),
                    Forms\Components\TextInput::make('hreflang')
                        ->label(trans('scribble::link.labels.language')),
                    Forms\Components\TextInput::make('rel')
                        ->columnSpan('full'),
                    Forms\Components\TextInput::make('referrerpolicy')
                        ->label(trans('scribble::link.labels.referrer_policy'))
                        ->columnSpan('full'),
                ]),
        ];
    }
}
