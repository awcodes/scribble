<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Italic extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-italic')
            ->label('Italic')
            ->extension('italic')
            ->active(extension: 'italic')
            ->commands([
                $this->makeCommand(command: 'toggleItalic'),
            ])
            ->converterExtension(\Tiptap\Marks\Italic::class);
    }
}
