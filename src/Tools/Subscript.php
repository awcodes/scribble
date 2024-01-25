<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Subscript extends ScribbleTool
{
    protected static string $icon = 'scribble-subscript';

    protected static string $label = 'Subscript';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleSubscript', 'arguments' => null],
        ];
    }
}
