<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Scribble\Helpers;
use Livewire\Component;

class Renderer extends Component
{
    public function getView(string $name, array $attrs)
    {
        foreach (Helpers::getBlockClasses() as $block) {
            if ($block::getName() === $name) {
                return $block::getView($attrs);
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
