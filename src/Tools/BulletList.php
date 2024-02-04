<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class BulletList extends ScribbleTool
{
    protected string $icon = 'scribble-list-ordered';

    protected string $label = 'BulletList';

    public function getCommands(): array | null
    {
        return [
            ['command' => 'toggleBulletList', 'arguments' => null]
        ];
    }
}
