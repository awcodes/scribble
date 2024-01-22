<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasLabel
{
    protected static string $label = 'Action';

    public static function getLabel(): string
    {
        return static::$label;
    }
}
