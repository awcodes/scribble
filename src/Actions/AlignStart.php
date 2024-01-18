<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class AlignStart extends ScribbleAction
{
    protected static string $icon = 'scribble-align-start';

    protected static string $label = 'Align Start';

    public static function getAction(): string
    {
        return 'setTextAlign';
    }

    public static function getActionArguments(): string | array
    {
        return 'start';
    }
}
