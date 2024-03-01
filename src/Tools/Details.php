<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Details extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-details')
            ->label('Details')
            ->extension('details')
            ->active(extension: 'details')
            ->commands([
                $this->makeCommand(command: 'setDetails'),
            ]);
    }
}
