<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasIdentifier
{
    protected ?string $identifier = null;

    public function identifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->evaluate($this->identifier) ?? str($this->name)->replace('_', '-')->kebab();
    }
}
