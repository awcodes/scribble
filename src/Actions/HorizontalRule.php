<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class HorizontalRule extends ScribbleAction
{
    protected static string $icon = 'scribble-hr';

    protected static string $label = 'Horizontal Rule';

    public static function getAction(): string
    {
        return 'setHorizontalRule';
    }
}
