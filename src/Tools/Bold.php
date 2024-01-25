<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Bold extends ScribbleTool
{
    protected static string $icon = 'scribble-bold';

    protected static string $label = 'Bold';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleBold', 'arguments' => null],
        ];
    }
}
