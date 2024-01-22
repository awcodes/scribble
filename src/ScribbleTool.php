<?php

namespace Awcodes\Scribble;

use Awcodes\Pounce\PounceComponent;
use Awcodes\Scribble\Tools\Concerns;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;

class ScribbleTool extends PounceComponent implements HasForms
{
    const COMMAND = 'command';

    const MODAL = 'modal';

    const BLOCK = 'block';

    use Concerns\HasDescription;
    use Concerns\HasIcon;
    use Concerns\HasLabel;
    use Concerns\HasView;
    use InteractsWithForms;

    public bool $update = false;

    public ?string $statePath = null;

    public array $data = [];

    protected static bool $shouldShowInBubbleMenu = false;

    protected static bool $shouldShowInSuggestionMenu = false;

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

    public static function getCommand(): ?string
    {
        return null;
    }

    public static function getCommandArguments(): string | array | null
    {
        return null;
    }

    public static function shouldShowInBubbleMenu(): bool
    {
        return static::$shouldShowInBubbleMenu;
    }

    public static function shouldShowInSuggestionMenu(): bool
    {
        return static::$shouldShowInSuggestionMenu;
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
