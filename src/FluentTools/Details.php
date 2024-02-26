<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Details extends Tool
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
