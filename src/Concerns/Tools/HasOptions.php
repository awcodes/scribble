<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasOptions
{
    protected ?string $optionsModal = null;

    public function optionsModal(string $component): static
    {
        $this->optionsModal = $component;

        return $this;
    }

    public function getOptionsModal(): ?string
    {
        return $this->optionsModal;
    }
}
