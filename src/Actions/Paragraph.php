<?php

namespace Awcodes\Scribble\Actions;

use Awcodes\Scribble\ScribbleAction;

class Paragraph extends ScribbleAction
{
    protected static string $icon = 'scribble-paragraph';

    protected static string $label = 'Paragraph';

    public static function getAction(): string
    {
        return 'setParagraph';
    }
}
