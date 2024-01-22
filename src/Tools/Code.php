<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Code extends ScribbleTool
{
    protected static string $icon = 'scribble-code';

    protected static string $label = 'Code';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommand(): ?string
    {
        return 'toggleCode';
    }
}
