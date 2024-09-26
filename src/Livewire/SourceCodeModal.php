<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Concerns\InteractsWithMedia;
use Filament\Forms\Components\Textarea;
use Filament\Support\Enums\MaxWidth;

class SourceCodeModal extends ScribbleModal
{
    use InteractsWithMedia;

    public ?string $header = 'Source Code';

    public ?string $identifier = 'sourceCode';

    public static ?MaxWidth $maxWidth = MaxWidth::Screen;

    public function mount(): void
    {
        $this->data = [
            'html' => $this->data['html'] ?? null,
        ];

        $this->form->fill([
            'source' => $this->data['html'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            TextArea::make('source')
                ->label(trans('scribble::source.labels.source'))
                ->extraAttributes(['class' => 'source_code_editor'])
                ->autosize(),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $content = $data['source'] ?? '<p></p>';

        $content = scribble($content)->toJson();

        $this->dispatch(
            event: 'updateContent',
            statePath: $this->statePath,
            newContent: $content,
        );

        $this->closeScribbleModal();
    }
}
