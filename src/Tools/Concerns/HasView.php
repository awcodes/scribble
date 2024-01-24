<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Illuminate\Support\Str;

trait HasView
{
    protected static string $view = 'scribble::components.action';

    public static function getView(array $attrs): string
    {
        return Str::of(view(static::$view, $attrs)->render())->replace("\n", '')->squish();
    }
}
