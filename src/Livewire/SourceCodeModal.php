<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Concerns\InteractsWithMedia;
use Awcodes\Scribble\Forms\Components\CodeInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
