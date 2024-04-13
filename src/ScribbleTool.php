<?php

namespace Awcodes\Scribble;

use Filament\Support\Components\Component;

class ScribbleTool extends Component
{
    use Concerns\Tools\CanBeHidden;
    use Concerns\Tools\HasConverterExtensions;
    use Concerns\Tools\HasDescription;
    use Concerns\Tools\HasEvents;
    use Concerns\Tools\HasIcon;
    use Concerns\Tools\HasIdentifier;
    use Concerns\Tools\HasLabel;
    use Concerns\Tools\HasName;
    use Concerns\Tools\HasOptions;
    use Concerns\Tools\HasStatePath;
    use Concerns\Tools\HasType;
    use Concerns\Tools\HasViews;
    use Concerns\Tools\InteractsWithTiptap;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(?string $name = null): static
    {
        if (! $name) {
            $name = str((new \ReflectionClass(static::class))->getShortName());
        }

        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function toArray(): array
    {
        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $this->getIdentifier(),
            'extension' => $this->getExtension(),
            'active' => $this->getActive(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'type' => $this->getType()->value,
            'commands' => $this->getCommands(),
            'isHidden' => $this->isHidden(),
            'options' => $this->getOptionsModal(),
            'event' => $this->getEvent(),
        ];
    }

    public function makeCommand(string $command, string | array | null $arguments = null): array
    {
        return Helpers::makeCommand($command, $arguments);
    }
}
