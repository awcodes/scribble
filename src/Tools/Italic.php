<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Italic extends ScribbleTool
{
    protected string $icon = 'scribble-italic';

    protected string $label = 'Italic';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleItalic', 'arguments' => null]
        ];
    }
}
