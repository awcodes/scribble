<?php

namespace Awcodes\Scribble;

use Awcodes\Pounce\PounceComponent;
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Tools\Concerns;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Contracts\View\View;

class ScribbleTool extends PounceComponent implements HasForms
{
    use EvaluatesClosures;
    use Concerns\CanBeHidden;
    use Concerns\HasDescription;
    use Concerns\HasIcon;
    use Concerns\HasLabel;
    use Concerns\HasView;
    use InteractsWithForms;

    public bool $update = false;

    public ?string $statePath = null;

    public ?string $blockId = null;

    public array $data = [];

    public function getExtension(): string
    {
        return lcfirst(substr(strrchr(static::class, '\\'), 1));
    }

    public function getIdentifier(): string
    {
        return 'scribble-' . lcfirst(substr(strrchr(static::class, '\\'), 1));
    }

    public function getType(): ToolType
    {
        return ToolType::Command;
    }

    public function getCommands(): array | null
    {
        return null;
    }

    public function getActiveAttributes(): string | array
    {
        return [];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $event = $this->update ? 'update' : 'insert';

        $this->dispatch(
            event: $event . '-' . static::getExtension(),
            statePath: $this->statePath,
            blockId: $this->blockId,
            values: $data
        );

        $this->unPounce();
    }

    public function render(): View
    {
        return view('scribble::components.form');
    }
}
