<?php

namespace Awcodes\Scribble;

use Awcodes\Pounce\PounceComponent;
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Tools\Concerns;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;

class ScribbleTool extends PounceComponent implements HasForms
{
    use Concerns\HasDescription;
    use Concerns\HasIcon;
    use Concerns\HasLabel;
    use Concerns\HasMenuLocations;
    use Concerns\HasView;
    use InteractsWithForms;

    public bool $update = false;

    public ?string $statePath = null;

    public array $data = [];

    public static function getExtension(): string
    {
        return lcfirst(substr(strrchr(static::class, '\\'), 1));
    }

    public static function getIdentifier(): string
    {
        return 'scribble-' . lcfirst(substr(strrchr(static::class, '\\'), 1));
    }

    public static function getType(): ToolType
    {
        return ToolType::Command;
    }

    public static function getCommands(): ?array
    {
        return null;
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        $this->dispatch(
            event: $event . '-' . static::getExtension(),
            statePath: $this->statePath,
            values: $data
        );

        $this->unPounce();
    }

    public function render(): View
    {
        return view('scribble::components.form');
    }
}
