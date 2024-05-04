<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Awcodes\Scribble\Profiles\DefaultProfile;
use Closure;
use Illuminate\Support\Arr;

trait HasProfileDefaults
{
    protected string | array | Closure $bubbleTool = [];

    protected string | array | Closure $suggestionTool = [];

    protected string | array | Closure $toolbarTool = [];

    public function bubbleTool(string | array | Closure $profiles = []): static
    {
        $this->bubbleTool = $profiles ?: DefaultProfile::class;

        return $this;
    }

    public function suggestionTool(string | array | Closure $profiles = []): static
    {
        $this->suggestionTool = $profiles ?: DefaultProfile::class;

        return $this;
    }

    public function toolbarTool(string | array | Closure $profiles = []): static
    {
        $this->toolbarTool = $profiles ?: DefaultProfile::class;

        return $this;
    }

    public function getBubbleTool(): array
    {
        return Arr::wrap($this->evaluate($this->bubbleTool) ?? []);
    }

    public function getSuggestionTool(): array
    {
        return Arr::wrap($this->evaluate($this->suggestionTool) ?? []);
    }

    public function getToolbarTool(): array
    {
        return Arr::wrap($this->evaluate($this->toolbarTool) ?? []);
    }
}
