<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasLabel
{
    protected string | Htmlable | Closure | null $label = null;

    protected bool $shouldTranslateLabel = false;

    public function label(string | Htmlable | Closure | null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function translateLabel(bool $shouldTranslateLabel = true): static
    {
        $this->shouldTranslateLabel = $shouldTranslateLabel;

        return $this;
    }

    public function getLabel(): string | Htmlable | null
    {
        $label = $this->evaluate($this->label) ?? (string) str($this->getName())
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();

        return $this->shouldTranslateLabel ? trans($label) : $label;
    }
}
