<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Italic extends ScribbleTool
{
    protected static string $icon = 'scribble-italic';

    protected static string $label = 'Italic';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleItalic', 'arguments' => null],
        ];
    }
}
