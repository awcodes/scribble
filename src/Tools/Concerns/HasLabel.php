<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasLabel
{
    protected string $label = 'Action';

    public function getLabel(): string
    {
        return $this->label;
    }
}
