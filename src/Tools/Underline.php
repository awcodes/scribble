<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Underline extends DefaultTool
{
    protected static string $icon = 'scribble-underline';

    protected static string $title = 'Underline';

    public static function getAction(): string
    {
        return 'toggleUnderline';
    }
}
