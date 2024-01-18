<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class AlignJustify extends ScribbleAction
{
    protected static string $icon = 'scribble-align-justify';

    protected static string $label = 'Align Justify';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'justify';
    }
}
