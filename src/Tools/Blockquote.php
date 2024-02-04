<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Blockquote extends ScribbleTool
{
    protected string $icon = 'scribble-blockquote';

    protected string $label = 'Blockquote';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleBlockquote', 'arguments' => null]
        ];
    }
}
