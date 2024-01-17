<?php

namespace Awcodes\Scribble\Blocks;

use Awcodes\Scribble\Block;

class DefaultBlock extends Block
{
    public static function getType(): string
    {
        return static::DEFAULT_TYPE;
    }
}
