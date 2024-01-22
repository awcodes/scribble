<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Blockquote extends ScribbleTool
{
    protected static string $icon = 'scribble-blockquote';

    protected static string $label = 'Blockquote';

    protected static bool $shouldShowInSuggestionMenu = true;

    public static function getCommand(): ?string
    {
        return 'toggleBlockquote';
    }
}
