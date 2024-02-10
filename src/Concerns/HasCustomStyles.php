<?php

namespace Awcodes\Scribble\Concerns;

use Closure;

trait HasCustomStyles
{
    protected string | Closure | null $customStyles = null;

    public function customStyles(string | Closure $styles): static
    {
        $this->customStyles = $styles;

        return $this;
    }

    public function getCustomStyles(): ?string
    {
        return $this->evaluate($this->customStyles) ?? null;
    }
}
