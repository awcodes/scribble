<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Blockquote extends ScribbleAction
{
    protected static string $icon = 'scribble-blockquote';

    protected static string $label = 'Blockquote';

    public static function getAction(): string
    {
        return 'toggleBlockquote';
    }
}
