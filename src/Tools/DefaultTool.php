<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class DefaultTool extends ScribbleTool
{
    public static function getType(): string
    {
        return static::DEFAULT_TYPE;
    }
}
