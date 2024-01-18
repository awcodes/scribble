<?php

namespace Awcodes\Scribble;

use Awcodes\Pounce\PounceComponent;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

class ScribbleBlock extends PounceComponent implements HasForms
{
    use InteractsWithForms;

    const DEFAULT_TYPE = 'default';

    const CUSTOM_TYPE = 'custom';

    protected static ?string $name = null;

    protected static string $view = 'scribble::components.block';

    protected static string $icon = 'heroicon-o-cube-transparent';

    protected static string $title = 'Block';

    protected static ?string $description = null;

    public bool $update = false;

    public array $data = [];

    public static function getBlockName(): string
    {
        return 'scribble.' . lcfirst(substr(strrchr(static::class, '\\'), 1));
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

    public static function getDescription(): ?string
    {
        return static::$description ?? null;
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

        $this->dispatch($event . '-' . $this->getName(), $data);

        $this->unPounce();
    }

    public function mount(array $data = []): void
    {
        $this->form->fill($data);

        $this->update = boolval($data);
    }

    public function render(): View
    {
        return view('scribble::components.form');
    }
}
