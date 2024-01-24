<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignStart extends ScribbleTool
{
    protected static string $icon = 'scribble-align-start';

    protected static string $label = 'Align Start';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): array | null
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'start']
        ];
    }
}
