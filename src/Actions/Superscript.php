<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Superscript extends ScribbleAction
{
    protected static string $icon = 'scribble-superscript';

    protected static string $label = 'Superscript';

    public static function getAction(): string
    {
        return 'toggleSuperscript';
    }
}
