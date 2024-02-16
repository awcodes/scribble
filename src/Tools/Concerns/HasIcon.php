<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

trait HasIcon
{
    protected string $icon = 'heroicon-o-cube-transparent';

    public function getIcon(): string
    {
        return svg($this->icon)->toHtml();
        return (string) Str::of(svg($this->icon)->toHtml())
            ->replace("\n", '')
            ->squish();
    }
}
