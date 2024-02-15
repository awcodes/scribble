<?php

namespace Awcodes\Scribble\Concerns;

interface HasScribbleProfile
{
    public static function bubbleTools(): array;

    public static function suggestionTools(): array;

    public static function toolbarTools(): array;
}
