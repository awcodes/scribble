<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignEnd extends ScribbleTool
{
    protected string $icon = 'scribble-align-end';

    protected string $label = 'Align End';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'end']
        ];
    }
}
