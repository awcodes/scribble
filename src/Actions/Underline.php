<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Underline extends ScribbleAction
{
    protected static string $icon = 'scribble-underline';

    protected static string $label = 'Underline';

    public static function getAction(): string
    {
        return 'toggleUnderline';
    }
}
