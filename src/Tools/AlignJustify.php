<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignJustify extends ScribbleTool
{
    protected string $icon = 'scribble-align-justify';

    protected string $label = 'Align Justify';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'justify']
        ];
    }
}
