<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Closure;

trait InteractsWithTiptap
{
    protected ?string $extension = null;

    protected array | Closure | null $commands = null;

    protected array | string | Closure | null $active = null;

    public function extension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function commands(array | Closure $commands): static
    {
        $this->commands = $commands;

        return $this;
    }

    public function active(string $extension, array | string | null $attrs = null): static
    {
        $this->active = [
            'extension' => $extension,
            'attrs' => $attrs ?? [],
        ];

        return $this;
    }

    public function getExtension(): string
    {
        return $this->evaluate($this->extension) ?? str($this->name)->replace('_', '-')->kebab();
    }

    public function getCommands(): array
    {
        return $this->evaluate($this->commands) ?? [];
    }

    public function getActive(): array
    {
        return filled($this->active) ? $this->evaluate($this->active) : ['extension' => $this->getExtension(), 'attrs' => []];
    }
}
