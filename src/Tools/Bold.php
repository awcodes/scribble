<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Illuminate\Support\Js;

class Bold extends ScribbleTool
{
    protected static string $icon = 'scribble-bold';

    protected static string $label = 'Bold';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommand(): ?string
    {
        return 'toggleBold';
    }
}
