<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Superscript extends ScribbleTool
{
    protected string $icon = 'scribble-superscript';

    protected string $label = 'Superscript';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleSuperscript', 'arguments' => null]
        ];
    }
}
