<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignEnd extends ScribbleTool
{
    protected static string $icon = 'scribble-align-end';

    protected static string $label = 'Align End';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommand(): ?string
    {
        return 'setTextAlign';
    }

    public static function getCommandArguments(): string | array | null
    {
        return 'end';
    }
}
