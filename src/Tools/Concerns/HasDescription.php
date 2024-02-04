<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasDescription
{
    protected ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }
}
