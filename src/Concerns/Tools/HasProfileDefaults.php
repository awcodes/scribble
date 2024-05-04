<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Awcodes\Scribble\Profiles\DefaultProfile;
use Closure;

trait HasProfileDefaults
{
    protected array | Closure $bubbleTool = [];

    protected array | Closure $suggestionTool = [];

    protected array | Closure $toolbarTool = [];

    public function bubbleTool(string | array | Closure $profiles = []): static
    {
        if (is_string($profiles)) {
            $profiles = [$profiles];
        }

        $this->bubbleTool = $profiles ?: [DefaultProfile::class];

        return $this;
    }

    public function suggestionTool(string | array | Closure $profiles = []): static
    {
        if (is_string($profiles)) {
            $profiles = [$profiles];
        }

        $this->suggestionTool = $profiles ?: [DefaultProfile::class];

        return $this;
    }

    public function toolbarTool(string | array | Closure $profiles = []): static
    {
        if (is_string($profiles)) {
            $profiles = [$profiles];
        }

        $this->toolbarTool = $profiles ?: [DefaultProfile::class];

        return $this;
    }

    public function getBubbleTool(): array
    {
        return $this->evaluate($this->bubbleTool) ?? [];
    }

    public function getSuggestionTool(): array
    {
        return $this->evaluate($this->suggestionTool) ?? [];
    }

    public function getToolbarTool(): array
    {
        return $this->evaluate($this->toolbarTool) ?? [];
    }
}
