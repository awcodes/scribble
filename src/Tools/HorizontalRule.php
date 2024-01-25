<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HorizontalRule extends ScribbleTool
{
    protected static string $icon = 'scribble-hr';

    protected static string $label = 'Horizontal Rule';

    protected static bool $shouldShowInSuggestionMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'setHorizontalRule', 'arguments' => null],
        ];
    }
}
