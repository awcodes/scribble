<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class BulletList extends ScribbleAction
{
    protected static string $icon = 'scribble-list-ordered';

    protected static string $label = 'BulletList';

    public static function getAction(): string
    {
        return 'toggleBulletList';
    }
}
