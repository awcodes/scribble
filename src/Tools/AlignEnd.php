<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignEnd extends ScribbleTool
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
