<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignCenter extends ScribbleTool
{
    protected static string $icon = 'scribble-align-center';

    protected static string $label = 'Align Center';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommand(): ?string
    {
        return 'setTextAlign';
    }

    public static function getCommandArguments(): string | array | null
    {
        return 'center';
    }
}
