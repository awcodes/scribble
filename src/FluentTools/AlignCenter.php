<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class AlignCenter extends Tool
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
