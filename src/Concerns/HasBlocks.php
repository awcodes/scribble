<?php

namespace Awcodes\Scribble\Concerns;

use Closure;

trait HasBlocks
{
    protected array | Closure | null $blocks = null;

    public function blocks(array | Closure | null $blocks): static
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function getBlocks(): array
    {
        return $this->evaluate($this->blocks) ?? [];
    }
}
