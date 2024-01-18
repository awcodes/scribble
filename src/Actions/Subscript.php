<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Subscript extends ScribbleAction
{
    protected static string $icon = 'scribble-subscript';

    protected static string $label = 'Subscript';

    public static function getAction(): string
    {
        return 'toggleSubscript';
    }
}
