<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignStart extends ScribbleTool
{
    protected string $icon = 'scribble-align-start';

    protected string $label = 'Align Start';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'start']
        ];
    }
}
