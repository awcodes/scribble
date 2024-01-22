<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Paragraph extends ScribbleTool
{
    protected static string $icon = 'scribble-paragraph';

    protected static string $label = 'Paragraph';

    protected static bool $shouldShowInBubbleMenu = true;

    public static function getCommand(): ?string
    {
        return 'setParagraph';
    }
}
