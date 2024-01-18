<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class AlignJustify extends DefaultTool
{
    protected static string $icon = 'scribble-align-justify';

    protected static string $title = 'Align Justify';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'justify';
    }
}
