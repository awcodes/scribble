<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Strike extends DefaultTool
{
    protected static string $icon = 'scribble-strike';

    protected static string $title = 'Strike';

    public static function getAction(): string
    {
        return 'toggleStrike';
    }
}
