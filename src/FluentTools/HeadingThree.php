<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingThree extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-three')
            ->label('Heading 3')
            ->extension('heading')
            ->order(3)
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->active(extension: 'heading', attrs: ['level' => 3])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 3]),
            ]);
    }
}
