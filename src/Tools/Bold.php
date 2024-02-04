<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Bold extends ScribbleTool
{
    protected string $icon = 'scribble-bold';

    protected string $label = 'Bold';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleBold', 'arguments' => null],
        ];
    }
}
