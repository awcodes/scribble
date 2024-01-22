<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasDescription
{
    protected static ?string $description = null;

    public static function getDescription(): ?string
    {
        return static::$description ?? null;
    }
}
