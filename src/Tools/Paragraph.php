<?php

namespace Awcodes\Scribble\Tools;

use Illuminate\Support\Js;
use JsonException;

class Paragraph extends DefaultTool
{
    protected static string $icon = 'scribble-paragraph';

    protected static string $title = 'Paragraph';

    public static function getAction(): string
    {
        return 'setParagraph';
    }
}
