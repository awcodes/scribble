<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Helpers;
use Awcodes\Scribble\ScribbleManager;
use Livewire\Attributes\Isolate;
use Livewire\Component;
use ReflectionException;

class Renderer extends Component
{
    #[Isolate]
    public function getView(string $identifier, array $attrs): ?string
    {
        $tool = app(ScribbleManager::class)->getTool($identifier);

        if (! $tool) {
            return null;
        }

        return $tool->getEditorView($attrs);
    }

    public function render(): string
    {
        return <<<'HTML'
        <div id="scribble-renderer"></div>
        HTML;
    }
}
