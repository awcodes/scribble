<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Strike extends ScribbleTool
{
    protected static string $icon = 'scribble-strike';

    protected static string $label = 'Strike';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleStrike', 'arguments' => null],
        ];
    }
}
