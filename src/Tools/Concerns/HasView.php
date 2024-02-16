<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasView
{
    protected string $view = 'scribble::components.action';

    protected ?string $renderedView = null;

    public function getView(array $attrs): string
    {
        return view($this->view, $attrs)->toHtml();
    }

    public function getRenderedView(array $attrs): string
    {
        $view = $this->renderedView ?? $this->view;

        return view($view, $attrs)->toHtml();
    }
}
