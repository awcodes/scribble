<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\ColorExtension;

class Color extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon(icon: 'scribble-color')
            ->label(label: 'Color')
            ->type(type: ToolType::Command)
            ->active(extension: 'color')
            ->commands([
                $this->makeCommand(command: 'setColor'),
            ])
            ->converterExtensions(new ColorExtension);
    }
}
