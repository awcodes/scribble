<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class AlignStart extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-start')
            ->label('Align Start')
            ->extension('textAlign')
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'start'),
            ]);
    }
}
