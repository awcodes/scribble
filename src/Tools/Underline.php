<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Underline extends ScribbleTool
{
    protected static string $icon = 'scribble-underline';

    protected static string $label = 'Underline';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): array | null
    {
        return [
            ['command' => 'toggleUnderline', 'arguments' => null]
        ];
    }
}
