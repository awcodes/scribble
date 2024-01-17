<?php

namespace Awcodes\Scribble\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Awcodes\Scribble\Scribble
 */
class Scribble extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Awcodes\Scribble\Scribble::class;
    }
}
