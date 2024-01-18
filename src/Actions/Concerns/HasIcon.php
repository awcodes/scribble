<?php

namespace Awcodes\Scribble\Actions\Concerns;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

trait HasIcon
{
    protected static string $icon = 'heroicon-o-cube-transparent';

    public static function getIcon(): string
    {
        return Str::of(Blade::render('<x-' . static::$icon . ' class="w-5 h-5" stroke-width="1.5"/>'))->replace("\n", "");
    }
}
