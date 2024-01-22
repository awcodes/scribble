<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasView
{
    protected static string $view = 'scribble::components.action';

    public static function getView(array $attrs): string
    {
        return view(static::$view, $attrs)->render();
    }
}
