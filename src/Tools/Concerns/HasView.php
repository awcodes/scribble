<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Illuminate\Support\Str;

trait HasView
{
    protected string $view = 'scribble::components.action';

    protected string | null $renderedView = null;

    public function getView(array $attrs): string
    {
        return (string) Str::of(view($this->view, $attrs)->render())
            ->replace("\n", '')
            ->squish();
    }

    public function getRenderedView(array $attrs): string
    {
        $view = $this->renderedView ?? $this->view;

        return (string) Str::of(view($view, $attrs)->render())
            ->replace("\n", '')
            ->squish();
    }
}
