<?php

namespace Awcodes\Scribble\Blocks;

use Awcodes\Scribble\ScribbleBlock;

class DefaultBlock extends ScribbleBlock
{
    public static function getType(): string
    {
        return static::DEFAULT_TYPE;
    }
}
