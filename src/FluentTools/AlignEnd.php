<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class AlignEnd extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-end')
            ->label('Align End')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'end'),
            ]);
    }
}
