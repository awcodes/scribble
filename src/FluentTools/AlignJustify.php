<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class AlignJustify extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-justify')
            ->label('Align Justify')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'justify'),
            ]);
    }
}
