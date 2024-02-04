<?php

namespace Awcodes\Scribble\Wrappers;

use Closure;
use Filament\Forms\Components\Concerns\HasLabel;
use Filament\Support\Concerns\EvaluatesClosures;

class Group
{
    use EvaluatesClosures;
    use HasLabel;

    protected array | Closure | null $tools = null;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label)
    {
        return app(static::class, ['label' => $label]);
    }

    public function tools(array | Closure | null $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function getTools(): array
    {
        return $this->evaluate($this->tools) ?? [];
    }
}
