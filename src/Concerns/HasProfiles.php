<?php

namespace Awcodes\Scribble\Concerns;

use Closure;

trait HasProfiles
{
    protected string | Closure | null $profile = null;

    public function profile(string | Closure | null $profile = null): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->evaluate($this->profile) ?? null;
    }
}
