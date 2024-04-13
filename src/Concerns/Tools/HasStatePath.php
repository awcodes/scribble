<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasStatePath
{
    protected ?string $statePath = null;

    public function statePath(string $statePath): static
    {
        $this->statePath = $statePath;

        return $this;
    }

    public function getStatePath(): ?string
    {
        return $this->statePath ?? null;
    }
}
