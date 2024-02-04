<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Code extends ScribbleTool
{
    protected string $icon = 'scribble-code';

    protected string $label = 'Code';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleCode', 'arguments' => null],
        ];
    }
}
