<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Closure;

trait CanBeHidden
{
    protected bool | Closure | null $isHidden = null;

    public function hidden(bool | Closure $condition = true): static
    {
        $this->isHidden = $condition;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->evaluate($this->isHidden) ?? false;
    }
}
