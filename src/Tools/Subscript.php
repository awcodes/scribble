<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Subscript extends ScribbleTool
{
    protected string $icon = 'scribble-subscript';

    protected string $label = 'Subscript';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleSubscript', 'arguments' => null]
        ];
    }
}
