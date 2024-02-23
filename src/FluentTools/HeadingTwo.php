<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingTwo extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-two')
            ->label('Heading 2')
            ->extension('heading')
            ->order(2)
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->active(extension: 'heading', attrs: ['level' => 2])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 2]),
            ]);
    }
}
