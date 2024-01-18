<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class AlignStart extends DefaultTool
{
    protected static string $icon = 'scribble-align-start';

    protected static string $title = 'Align Start';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'start';
    }
}
