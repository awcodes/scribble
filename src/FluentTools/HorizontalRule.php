<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HorizontalRule extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-hr')
            ->label('Horizontal Rule')
            ->extension('horizontalRule')
            ->defaultSuggestionTool()
            ->commands([
                $this->makeCommand(command: 'setHorizontalRule'),
            ]);
    }
}
