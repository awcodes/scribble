<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class BulletList extends ScribbleTool
{
    protected static string $icon = 'scribble-list-ordered';

    protected static string $label = 'BulletList';

    protected static bool $shouldShowInBubbleMenu = true;

    protected static bool $shouldShowInSuggestionMenu = true;

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleBulletList', 'arguments' => null],
        ];
    }
}
