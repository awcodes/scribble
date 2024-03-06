<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasEvents
{
    protected array | null $event = null;

    public function event(string $name, array | null $data = null): static
    {
        $this->event = [
            'name' => $name,
            'data' => $data,
        ];

        return $this;
    }

    public function getEvent(): array
    {
        return filled($this->event) ? $this->evaluate($this->event) : ['name' => null, 'data' => null];
    }
}
