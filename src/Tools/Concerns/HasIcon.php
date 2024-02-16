<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasIcon
{
    protected string $icon = 'heroicon-o-cube';

    public function getIcon(): string
    {
        return svg($this->icon)->toHtml();
    }
}
