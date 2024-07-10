<?php

namespace Awcodes\Scribble\Livewire;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Get;

class EmbedModal extends ScribbleModal
{
    public ?string $header = 'Embed';

    public function getFormFields(): array
    {
        return [
            TextInput::make('src')
                ->label(trans('scribble::embed.labels.url'))
                ->live()
                ->required(),
            CheckboxList::make('options')
                ->hiddenLabel()
                ->gridDirection('row')
                ->columns(3)
                ->visible(function (Get $get) {
                    return $get('src');
                })
                ->options(function (Get $get) {
                    if (str_contains($get('src'), 'youtu')) {
                        return [
                            'controls' => trans('scribble::embed.labels.controls'),
                            'nocookie' => trans('scribble::embed.labels.nocookie'),
                        ];
                    }

                    return [
                        'autoplay' => trans('scribble::embed.labels.autoplay'),
                        'loop' => trans('scribble::embed.labels.loop'),
                        'title' => trans('scribble::embed.labels.title'),
                        'byline' => trans('scribble::embed.labels.byline'),
                        'portrait' => trans('scribble::embed.labels.portrait'),
                    ];
                })
                ->dehydrateStateUsing(function (Get $get, $state) {
                    if (str_contains($get('src'), 'youtu')) {
                        return [
                            'controls' => in_array('controls', $state) ? 1 : 0,
                            'nocookie' => in_array('nocookie', $state) ? 1 : 0,
                        ];
                    } else {
                        return [
                            'autoplay' => in_array('autoplay', $state) ? 1 : 0,
                            'loop' => in_array('loop', $state) ? 1 : 0,
                            'title' => in_array('title', $state) ? 1 : 0,
                            'byline' => in_array('byline', $state) ? 1 : 0,
                            'portrait' => in_array('portrait', $state) ? 1 : 0,
                        ];
                    }
                }),
            TimePicker::make('start_at')
                ->label(trans('scribble::embed.labels.start_at'))
                ->live()
                ->date(false)
                ->visible(function (Get $get) {
                    return str_contains($get('src'), 'youtu');
                })
                ->afterStateHydrated(function (TimePicker $component, $state): void {
                    if (! $state) {
                        return;
                    }

                    $state = CarbonInterval::seconds($state)->cascade();
                    $component->state(Carbon::parse($state->h . ':' . $state->i . ':' . $state->s)->format('Y-m-d H:i:s'));
                })
                ->dehydrateStateUsing(function ($state): int {
                    if (! $state) {
                        return 0;
                    }

                    return Carbon::parse($state)->diffInSeconds('00:00:00');
                }),
            Checkbox::make('responsive')
                ->default(true)
                ->live()
                ->label(trans('scribble::embed.labels.responsive'))
                ->afterStateUpdated(function (callable $set, $state) {
                    if ($state) {
                        $set('width', '16');
                        $set('height', '9');
                    } else {
                        $set('width', '640');
                        $set('height', '480');
                    }
                })
                ->columnSpan('full'),
            Group::make([
                TextInput::make('width')
                    ->live()
                    ->required()
                    ->label(trans('scribble::embed.labels.width'))
                    ->default('16'),
                TextInput::make('height')
                    ->live()
                    ->required()
                    ->label(trans('scribble::embed.labels.height'))
                    ->default('9'),
            ])->columns(['md' => 2]),
        ];
    }
}
