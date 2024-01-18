<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Bold extends DefaultTool
{
    protected static string $icon = 'scribble-bold';

    protected static string $title = 'Bold';

    public static function getAction(): string
    {
        return 'toggleBold';
    }
}
