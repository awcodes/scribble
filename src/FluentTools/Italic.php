<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Italic extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-italic')
            ->label('Italic')
            ->extension('italic')
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->active(extension: 'italic')
            ->commands([
                $this->makeCommand(command: 'toggleItalic'),
            ]);
    }
}
