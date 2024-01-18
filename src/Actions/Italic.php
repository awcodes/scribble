<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Italic extends ScribbleAction
{
    protected static string $icon = 'scribble-italic';

    protected static string $label = 'Italic';

    public static function getAction(): string
    {
        return 'toggleItalic';
    }
}
