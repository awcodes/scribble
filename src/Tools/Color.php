<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\ColorModal;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\ColorExtension;

class Color extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon(icon: 'scribble-color')
            ->label(label: 'Color')
            ->type(type: ToolType::Modal)
            ->active(extension: 'color')
            ->commands([
                $this->makeCommand(command: 'setColor'),
            ])
            ->optionsModal(component: ColorModal::class)
            ->converterExtensions(new ColorExtension());
    }
}
