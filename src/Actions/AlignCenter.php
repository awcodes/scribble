<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class AlignCenter extends ScribbleAction
{
    protected static string $icon = 'scribble-align-center';

    protected static string $label = 'Align Center';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'center';
    }
}
