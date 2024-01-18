<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Subscript extends DefaultTool
{
    protected static string $icon = 'scribble-subscript';

    protected static string $title = 'Subscript';

    public static function getAction(): string
    {
        return 'toggleSubscript';
    }
}
