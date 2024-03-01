<?php

namespace Awcodes\Scribble\Contracts;

interface HasScribbleProfile
{
    public static function bubbleTools(): array;

    public static function suggestionTools(): array;

    public static function toolbarTools(): array;
}
