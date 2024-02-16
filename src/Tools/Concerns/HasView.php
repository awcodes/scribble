<?php

namespace Awcodes\Scribble\Tools\Concerns;

trait HasView
{
    protected ?string $view = null;

    protected ?string $editorView = null;

    public function getView(array $attrs): string
    {
        return view($this->view, $attrs)->toHtml();
    }

    public function getEditorView(array $attrs): string
    {
        $view = $this->editorView ?? $this->view;

        return view($view, $attrs)->toHtml();
    }
}
