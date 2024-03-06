<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Bold extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-bold')
            ->label('Bold')
            ->extension('bold')
            ->active(extension: 'bold')
            ->commands([
                $this->makeCommand(command: 'toggleBold'),
            ])
            ->converterExtension(\Tiptap\Marks\Bold::class);
    }
}
