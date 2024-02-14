<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Details extends ScribbleTool
{
    protected string $icon = 'scribble-details';

    protected string $label = 'Details';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'setDetails', 'arguments' => null],
        ];
    }
}
