<?php

use Awcodes\Scribble\Utils\Converter;

if (! function_exists('scribble')) {
    function scribble($content): Converter
    {
        return new Converter($content);
    }
}
