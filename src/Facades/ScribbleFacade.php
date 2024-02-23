<?php

namespace Awcodes\Scribble\Facades;

use Illuminate\Support\Facades\Facade;

class ScribbleFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Awcodes\Scribble\ScribbleManager::class;
    }
}
