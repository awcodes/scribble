<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Closure;

trait HasProfileDefaults
{
    protected bool | Closure $bubbleTool = false;

    protected bool | Closure $suggestionTool = false;

    protected bool | Closure $toolbarTool = false;

    public function bubbleTool(bool | Closure $condition = true): static
    {
        $this->bubbleTool = $condition;

        return $this;
    }

    public function suggestionTool(bool | Closure $condition = true): static
    {
        $this->suggestionTool = $condition;

        return $this;
    }

    public function toolbarTool(bool | Closure $condition = true): static
    {
        $this->toolbarTool = $condition;

        return $this;
    }

    public function getBubbleTool(): bool
    {
        return $this->evaluate($this->bubbleTool) ?? false;
    }

    public function getSuggestionTool(): bool
    {
        return $this->evaluate($this->suggestionTool) ?? false;
    }

    public function getToolbarTool(): bool
    {
        return $this->evaluate($this->toolbarTool) ?? false;
    }
}
