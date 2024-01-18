<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class AlignEnd extends ScribbleAction
{
    protected static string $icon = 'scribble-align-end';

    protected static string $label = 'Align End';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'end';
    }
}
