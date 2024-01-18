<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Bold extends ScribbleAction
{
    protected static string $icon = 'scribble-bold';

    protected static string $label = 'Bold';

    public static function getAction(): string
    {
        return 'toggleBold';
    }
}
