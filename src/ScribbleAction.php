<?php

namespace Awcodes\Scribble;

use Awcodes\Pounce\PounceComponent;
use Awcodes\Scribble\Actions\Concerns;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;

class ScribbleAction extends PounceComponent implements HasForms
{
    const COMMAND = 'command';
    const MODAL = 'modal';
    const BLOCK = 'block';

    use InteractsWithForms;
    use Concerns\HasDescription;
    use Concerns\HasIcon;
    use Concerns\HasLabel;
    use Concerns\HasView;

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

    public static function getType(): string
    {
        return static::COMMAND;
    }

    public static function getAction(): string
    {
        return '';
    }

    public static function getActionArguments(): string | array
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
            data: $data
        );

        $this->unPounce();
    }

    public function render(): View
    {
        return view('scribble::components.form');
    }
}
