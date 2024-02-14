<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingFive extends ScribbleTool
{
    protected string $icon = 'scribble-heading-five';

    protected string $label = 'Heading 5';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 5]],
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 5,
        ];
    }
}
