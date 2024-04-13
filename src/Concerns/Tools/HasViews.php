<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Exception;
use Illuminate\Contracts\View\View;

trait HasViews
{
    protected ?string $editorView = null;

    protected ?string $renderedView = null;

    public function editorView(string $view): static
    {
        $this->editorView = $view;

        return $this;
    }

    public function renderedView(string $view): static
    {
        $this->renderedView = $view;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getEditorView(array $data = []): View
    {
        if (! $this->evaluate($this->editorView)) {
            return $this->getRenderedView($data);
        }

        return view($this->evaluate($this->editorView), $data);
    }

    /**
     * @throws Exception
     */
    public function getRenderedView(array $data = []): View
    {
        if (! view()->exists($this->evaluate($this->renderedView))) {
            throw new Exception('Rendered view not found: ' . $this->evaluate($this->renderedView));
        }

        return view($this->evaluate($this->renderedView), $data);
    }
}
