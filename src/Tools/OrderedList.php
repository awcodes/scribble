<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class OrderedList extends ScribbleTool
{
    protected string $icon = 'scribble-list-ordered';

    protected string $label = 'OrderedList';

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleOrderedList', 'arguments' => null],
        ];
    }
}
