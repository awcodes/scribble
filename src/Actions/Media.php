<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Scribble\Actions\Concerns\InteractsWithMedia;
use Awcodes\Scribble\ScribbleAction;
use Filament\Forms;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Media extends ScribbleAction
{
    use InteractsWithMedia;

    protected static string $icon = 'scribble-media';

    protected static string $label = 'Media';

    protected static string $view = 'scribble::actions.media';

    public ?string $statePath = null;

    public ?string $disk = null;
    public ?string $directory = null;
    public ?array $acceptedFileTypes = null;
    public ?int $maxFileSize = null;
    public ?string $src = null;
    public ?string $alt = null;
    public ?string $title = null;
    public ?int $width = null;
    public ?int $height = null;
    public ?bool $lazyLoad = false;
    public ?string $linkText = null;
    public ?string $fileType = null;

    public static function getType(): string
    {
        return static::MODAL;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::TwoExtraLarge;
    }

    public function mount(): void
    {
        $source = $this->src
            ? $this->getDirectory() . Str::of($this->src)->after($this->getDirectory())
            : null;

        $this->form->fill([
            'src' => $source,
            'alt' => $this->alt,
            'title' => $this->title,
            'width' => $this->width,
            'height' => $this->height,
            'lazy' => $this->lazyLoad ?? false,
            'link_text' => $this->linkText,
            'type' => $this->fileType,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
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
                                ->afterStateUpdated(function (TemporaryUploadedFile $state, Set $set) {
                                    if (Str::contains($state->getMimeType(), 'image')) {
                                        $set('type', 'image');
                                    } else {
                                        $set('type', 'document');
                                    }

                                    if ($dimensions = $state->dimensions()) {
                                        $set('width', $dimensions[0]);
                                        $set('height', $dimensions[1]);
                                    }
                                })
                                ->saveUploadedFileUsing(function (BaseFileUpload $component, TemporaryUploadedFile $file) {
                                    $filename = $component->shouldPreserveFilenames()
                                        ? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                                        : Str::uuid();
                                    $storeMethod = $component->getVisibility() === 'public' ? 'storePubliclyAs' : 'storeAs';
                                    $extension = $file->getClientOriginalExtension();

                                    if (Storage::disk($component->getDiskName())->exists(ltrim($component->getDirectory() . '/' . $filename . '.' . $extension, '/'))) {
                                        $filename = $filename . '-' . time();
                                    }

                                    $upload = $file->{$storeMethod}($component->getDirectory(), $filename . '.' . $extension, $component->getDiskName());

                                    return Storage::disk($component->getDiskName())->url($upload);
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
                                        ->url('https://www.w3.org/WAI/tutorials/images/decision-tree', true)
                                ),
                            TextInput::make('title')
                                ->label(trans('scribble::media.labels.title')),
                            Group::make([
                                TextInput::make('width'),
                                TextInput::make('height'),
                            ])->columns()->hidden(fn (Get $get) => $get('type') == 'document'),
                            Checkbox::make('lazy')
                                ->label(trans('scribble::media.labels.lazy'))
                                ->hidden(fn (Get $get) => $get('type') == 'document'),
                        ])->columnSpan(1),
                    ]),
                Hidden::make('type')
                    ->default('document'),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        if (config('scribble.media.use_relative_paths')) {
            $source = Str::of($data['src'])
                ->replace(config('app.url'), '')
                ->ltrim('/')
                ->prepend('/');
        } else {
            $source = str_starts_with($data['src'], 'http')
                ? $data['src']
                : Storage::disk(config('scribble.media.disk'))->url($data['src']);
        }

        $this->dispatch(
            event: $event . '-' . static::getExtension(),
            statePath: $this->statePath,
            data: [
                'src' => $source,
                ...$data,
            ]
        );

        $this->unPounce();
    }
}
