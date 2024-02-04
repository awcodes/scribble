<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingTwo extends ScribbleTool
{
    protected string $icon = 'scribble-heading-two';

    protected string $label = 'Heading 2';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 2]]
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 2
        ];
    }
}
