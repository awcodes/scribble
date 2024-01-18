<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class BulletList extends DefaultTool
{
    protected static string $icon = 'scribble-list-ordered';

    protected static string $title = 'BulletList';

    public static function getAction(): string
    {
        return 'toggleBulletList';
    }
}
