<?php

namespace Awcodes\Scribble\Actions\Concerns;

trait HasLabel
{
    protected static string $label = 'Action';

    public static function getLabel(): string
    {
        return static::$label;
    }
}
