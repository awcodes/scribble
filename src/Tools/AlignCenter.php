<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class AlignCenter extends DefaultTool
{
    protected static string $icon = 'scribble-align-center';

    protected static string $title = 'Align Center';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'center';
    }
}
