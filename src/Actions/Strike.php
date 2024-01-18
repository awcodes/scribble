<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Strike extends ScribbleAction
{
    protected static string $icon = 'scribble-strike';

    protected static string $label = 'Strike';

    public static function getAction(): string
    {
        return 'toggleStrike';
    }
}
