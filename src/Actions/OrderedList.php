<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class OrderedList extends ScribbleAction
{
    protected static string $icon = 'scribble-list-ordered';

    protected static string $label = 'OrderedList';

    public static function getAction(): string
    {
        return 'toggleOrderedList';
    }
}
