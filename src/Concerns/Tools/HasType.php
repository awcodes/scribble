<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Closure;

trait HasType
{
    protected ToolType | Closure | null $type = null;

    public function type(ToolType | Closure $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ToolType
    {
        return $this->evaluate($this->type) ?? ToolType::Command;
    }
}
