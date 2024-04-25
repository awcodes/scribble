<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Concerns\InteractsWithMedia;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MediaModal extends ScribbleModal
{
    use InteractsWithMedia;

    public ?string $header = 'Media';

    public ?string $identifier = 'media';

    public static ?MaxWidth $maxWidth = MaxWidth::TwoExtraLarge;

    public function mount(): void
    {
        $this->data['src'] = $this->data['src'] ?? null;
        $this->data['alt'] = $this->data['alt'] ?? null;
        $this->data['title'] = $this->data['title'] ?? null;
        $this->data['width'] = $this->data['width'] ?? null;
        $this->data['height'] = $this->data['height'] ?? null;
        $this->data['loading'] = $this->data['loading'] ?? null;
        $this->data['link_text'] = $this->data['link_text'] ?? null;
        $this->data['type'] = $this->data['type'] ?? null;
        $this->data['coordinates'] = $this->data['coordinates'] ?? null;

        $source = $this->data['src']
            ? $this->getDirectory() . Str::of($this->data['src'])->after($this->getDirectory())
            : null;

        $this->form->fill([
            'src' => $source,
            'alt' => $this->data['alt'],
            'title' => $this->data['title'],
            'width' => $this->data['width'],
            'height' => $this->data['height'],
            'loading' => $this->data['loading'],
            'link_text' => $this->data['link_text'],
            'type' => $this->data['type'],
        ]);
    }

    public function getFormFields(): array
    {
        return [
            Grid::make()
                ->schema([
                    Group::make([
                        FileUpload::make('src')
                            ->label(trans('scribble::media.labels.file'))
                            ->disk($this->getDisk())
                            ->directory($this->getDirectory())
                            ->visibility($this->getVisibility())
                            ->preserveFilenames($this->shouldPreserveFileNames())
                            ->acceptedFileTypes($this->getAcceptedFileTypes())
                            ->maxFiles(1)
                            ->maxSize($this->getMaxFileSize())
                            ->imageResizeMode($this->getImageResizeMode())
                            ->imageCropAspectRatio($this->getImageCropAspectRatio())
                            ->imageResizeTargetWidth($this->getImageResizeTargetWidth())
                            ->imageResizeTargetHeight($this->getImageResizeTargetHeight())
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (TemporaryUploadedFile $state, Set $set): void {
                                if (Str::contains($state->getMimeType(), 'image')) {
                                    $set('type', 'image');
                                    if (! Str::contains($state->getMimeType(), 'svg')) {
                                        $set('width', $state->dimensions()[0]);
                                        $set('height', $state->dimensions()[1]);
                                    }
                                } else {
                                    $set('type', 'document');
                                }
                            })
                            ->saveUploadedFileUsing(function (BaseFileUpload $component, TemporaryUploadedFile $file): string {
                                $filename = $component->shouldPreserveFilenames()
                                    ? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                                    : Str::uuid();
                                $storeMethod = $component->getVisibility() === 'public' ? 'storePubliclyAs' : 'storeAs';
                                $extension = $file->getClientOriginalExtension();
                                $storage = Storage::disk($component->getDiskName());

                                if ($storage->exists(ltrim($component->getDirectory() . '/' . $filename . '.' . $extension, '/'))) {
                                    $filename = $filename . '-' . time();
                                }

                                $upload = $file->{$storeMethod}($component->getDirectory(), $filename . '.' . $extension, $component->getDiskName());

                                return $storage->url($upload);
                            }),
                    ])->columnSpan(1),
                    Group::make([
                        TextInput::make('link_text')
                            ->label(trans('scribble::media.labels.link_text'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') == 'document'),
                        TextInput::make('alt')
                            ->label(trans('scribble::media.labels.alt'))
                            ->hidden(fn (Get $get) => $get('type') == 'document')
                            ->hintAction(
                                Action::make('alt_hint_action')
                                    ->label('?')
                                    ->color('primary')
                                    ->tooltip(trans('scribble::media.labels.alt_hint_tooltip'))
                                    ->url('https://www.w3.org/WAI/tutorials/images/decision-tree', true)
                            ),
                        TextInput::make('title')
                            ->label(trans('scribble::media.labels.title')),
                        Group::make([
                            TextInput::make('width'),
                            TextInput::make('height'),
                        ])->columns()->hidden(fn (Get $get) => $get('type') == 'document'),
                        Checkbox::make('loading')
                            ->label(trans('scribble::media.labels.lazy'))
                            ->dehydrateStateUsing(function ($state): ?string {
                                if ($state) {
                                    return 'lazy';
                                }

                                return null;
                            })
                            ->hidden(fn (Get $get) => $get('type') == 'document'),
                    ])->columnSpan(1),
                ]),
            Hidden::make('type')
                ->default('document'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $source = str_starts_with($data['src'], 'http')
            ? $data['src']
            : Storage::disk($this->getDisk())->url($data['src']);

        if (config('scribble.media.use_relative_paths')) {
            $source = (string) Str::of($source)
                ->replace(config('app.url'), '')
                ->ltrim('/')
                ->prepend('/');
        }

        $this->dispatch(
            event: 'handle-' . $this->identifier,
            statePath: $this->statePath,
            blockId: $this->blockId,
            context: $this->update ? 'update' : 'insert',
            values: [
                ...$data,
                'src' => $source,
            ],
            coordinates: $this->coordinates,
        );

        $this->closeScribbleModal();
    }
}
