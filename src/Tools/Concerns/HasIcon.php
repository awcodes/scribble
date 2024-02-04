<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

trait HasIcon
{
    protected string $icon = 'heroicon-o-cube-transparent';

    public function getIcon(): string
    {
        return (string) Str::of(Blade::render('<x-' . $this->icon . ' stroke-width="1.5"/>'))
            ->replace("\n", '')
            ->squish();
    }
}
