<?php

namespace Awcodes\Scribble;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

class Block extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    const DEFAULT_TYPE = 'default';

    const CUSTOM_TYPE = 'custom';

    protected static ?string $name = null;

    protected static string $view = 'filament-papyrus::components.block';

    protected static string $icon = 'heroicon-o-lightning-bolt';

    protected static string $title = 'Block';

    protected static string $description = 'Block description';

    public bool $update = false;

    public array $data = [];

    public static function getName(): string
    {
        return 'scribble.' . strtolower(substr(strrchr(static::class, '\\'), 1));
    }

    public static function getView(array $attrs): string
    {
        return view(static::$view, $attrs)->render();
    }

    public static function getIcon(): string
    {
        return Blade::render('<x-' . static::$icon . ' class="w-5 h-5" stroke-width="1.5"/>');
    }

    public static function getTitle(): string
    {
        return static::$title;
    }

    public static function getDescription(): string
    {
        return static::$description ?: 'Block description';
    }

    public static function getType(): string
    {
        return static::CUSTOM_TYPE;
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function action(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        $this->dispatchBrowserEvent($event . '-' . static::getName(), $data);

        $this->closeModal();
    }

    public function mount(array $data = []): void
    {
        $this->form->fill($data);

        $this->update = boolval($data);
    }

    public function render(): View
    {
        return view('papyrus::components.form');
    }
}
