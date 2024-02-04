<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Strike extends ScribbleTool
{
    protected string $icon = 'scribble-strike';

    protected string $label = 'Strike';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleStrike', 'arguments' => null]
        ];
    }
}
