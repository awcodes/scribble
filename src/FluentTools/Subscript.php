<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Subscript extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-subscript')
            ->label('Subscript')
            ->extension('subscript')
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->active(extension: 'subscript')
            ->commands([
                $this->makeCommand(command: 'toggleSubscript'),
            ]);
    }
}
