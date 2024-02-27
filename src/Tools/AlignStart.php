<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class AlignStart extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-start')
            ->label('Align Start')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'start'),
            ]);
    }
}
