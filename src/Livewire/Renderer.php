<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Helpers;
use Livewire\Attributes\Isolate;
use Livewire\Component;
use ReflectionException;

class Renderer extends Component
{
    /**
     * @throws ReflectionException
     */
    #[Isolate]
    public function getView(string $identifier, array $attrs)
    {
        foreach (Helpers::getToolClasses() as $block) {
            $block = new $block();

            if ($block->getIdentifier() === $identifier) {
                return $block->getEditorView($attrs);
            }
        }
    }

    public function render(): string
    {
        return <<<'HTML'
        <div id="scribble-renderer"></div>
        HTML;
    }
}
