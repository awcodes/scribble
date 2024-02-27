<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\ScribbleManager;
use Livewire\Attributes\Isolate;
use Livewire\Component;

class Renderer extends Component
{
    #[Isolate]
    public function getView(string $identifier, array $attrs): ?string
    {
        $tool = app(ScribbleManager::class)->getTools($identifier)->sole();

        if (! $tool) {
            return null;
        }

        return $tool->getEditorView($attrs)->toHtml();
    }

    public function render(): string
    {
        return <<<'HTML'
        <div id="scribble-renderer"></div>
        HTML;
    }
}
