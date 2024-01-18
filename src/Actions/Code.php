<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Code extends ScribbleAction
{
    protected static string $icon = 'scribble-code';

    protected static string $label = 'Code';

    public static function getAction(): string
    {
        return 'toggleCode';
    }
}
