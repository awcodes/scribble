<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Paragraph extends ScribbleTool
{
    protected string $icon = 'scribble-paragraph';

    protected string $label = 'Paragraph';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'setParagraph', 'arguments' => null],
        ];
    }
}
