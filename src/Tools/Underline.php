<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Underline extends ScribbleTool
{
    protected string $icon = 'scribble-underline';

    protected string $label = 'Underline';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleUnderline', 'arguments' => null],
        ];
    }
}
