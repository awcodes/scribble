<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Code extends DefaultTool
{
    protected static string $icon = 'scribble-code';

    protected static string $title = 'Code';

    public static function getAction(): string
    {
        return 'toggleCode';
    }
}
