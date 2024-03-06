<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasConverterExtension
{
    protected string | array | null $converterExtension = null;

    protected ?array $converterExtensionOptions = null;

    public function converterExtension(string | array $class): static
    {
        $this->converterExtension = $class;

        return $this;
    }

    public function converterExtensionOptions(array $options): static
    {
        $this->converterExtensionOptions = $options;

        return $this;
    }

    public function getConverterExtension(): string | array | null
    {
        return $this->converterExtension ?? null;
    }

    public function getConverterExtensionOptions(): array
    {
        return $this->converterExtensionOptions ?? [];
    }
}
