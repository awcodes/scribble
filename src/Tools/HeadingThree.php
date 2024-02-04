<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingThree extends ScribbleTool
{
    protected string $icon = 'scribble-heading-three';

    protected string $label = 'Heading 3';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 3]]
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 3
        ];
    }
}
