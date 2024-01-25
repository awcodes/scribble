<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignJustify extends ScribbleTool
{
    protected static string $icon = 'scribble-align-justify';

    protected static string $label = 'Align Justify';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'setTextAlign', 'arguments' => 'justify'],
        ];
    }
}
