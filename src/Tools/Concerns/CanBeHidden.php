<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Closure;

trait CanBeHidden
{
    public bool | Closure | null $isHidden = null;

    public function hidden(bool | Closure | null $hidden = true): static
    {
        $this->isHidden = $hidden;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->evaluate($this->isHidden) ?? false;
    }
}
