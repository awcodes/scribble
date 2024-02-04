<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HorizontalRule extends ScribbleTool
{
    protected string $icon = 'scribble-hr';

    protected string $label = 'Horizontal Rule';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'setHorizontalRule', 'arguments' => null],
        ];
    }
}
