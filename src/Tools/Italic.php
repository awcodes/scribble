<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Italic extends DefaultTool
{
    protected static string $icon = 'scribble-italic';

    protected static string $title = 'Italic';

    public static function getAction(): string
    {
        return 'toggleItalic';
    }
}
