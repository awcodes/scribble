<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasMenuLocations
{
    protected static bool $shouldShowInBubbleMenu = false;

    protected static bool $shouldShowInSuggestionMenu = false;

    public static function shouldShowInBubbleMenu(): bool
    {
        return static::$shouldShowInBubbleMenu;
    }

    public static function shouldShowInSuggestionMenu(): bool
    {
        return static::$shouldShowInSuggestionMenu;
    }

}
