<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Helpers;
use Livewire\Component;

class Renderer extends Component
{
    public function getView(string $identifier, array $attrs)
    {
        foreach (Helpers::getToolClasses() as $block) {
            $block = new $block();

            if ($block->getIdentifier() === $identifier) {
                return $block->getView($attrs);
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
