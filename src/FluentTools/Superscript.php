<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Superscript extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-superscript')
            ->label('Superscript')
            ->extension('superscript')
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->active(extension: 'superscript')
            ->commands([
                $this->makeCommand(command: 'toggleSuperscript'),
            ]);
    }
}
