<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Superscript extends DefaultTool
{
    protected static string $icon = 'scribble-superscript';

    protected static string $title = 'Superscript';

    public static function getAction(): string
    {
        return 'toggleSuperscript';
    }
}
