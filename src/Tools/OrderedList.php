<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class OrderedList extends DefaultTool
{
    protected static string $icon = 'scribble-list-ordered';

    protected static string $title = 'OrderedList';

    public static function getAction(): string
    {
        return 'toggleOrderedList';
    }
}
