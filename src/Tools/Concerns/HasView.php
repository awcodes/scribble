<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Illuminate\Support\Str;

trait HasView
{
    protected string $view = 'scribble::components.action';

    public function getView(array $attrs): string
    {
        return (string) Str::of(view($this->view, $attrs)->render())
            ->replace("\n", '')
            ->squish();
    }
}
