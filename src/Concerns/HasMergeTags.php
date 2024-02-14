<?php

namespace Awcodes\Scribble\Concerns;

trait HasMergeTags
{
    protected ?array $mergeTags = [];

    public function mergeTags(?array $mergeTags): static
    {
        $this->mergeTags = $mergeTags;

        return $this;
    }

    public function getMergeTags(): ?array
    {
        return $this->mergeTags;
    }
}
