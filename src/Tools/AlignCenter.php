<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignCenter extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-center')
            ->label('Align Center')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'center'),
            ]);
    }
}
