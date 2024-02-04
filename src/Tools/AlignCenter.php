<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignCenter extends ScribbleTool
{
    protected string $icon = 'scribble-align-center';

    protected string $label = 'Align Center';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'center'],
        ];
    }
}
