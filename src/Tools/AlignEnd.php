<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class AlignEnd extends DefaultTool
{
    protected static string $icon = 'scribble-align-end';

    protected static string $title = 'Align End';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'end';
    }
}
