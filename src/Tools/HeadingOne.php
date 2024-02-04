<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingOne extends ScribbleTool
{
    protected string $icon = 'scribble-heading-one';

    protected string $label = 'Heading 1';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 1]]
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 1
        ];
    }
}
