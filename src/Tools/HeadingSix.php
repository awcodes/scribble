<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingSix extends ScribbleTool
{
    protected string $icon = 'scribble-heading-six';

    protected string $label = 'Heading 6';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 6]],
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 6,
        ];
    }
}
