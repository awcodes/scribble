<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Bold extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-bold')
            ->label('Bold')
            ->extension('bold')
            ->active(extension: 'bold')
            ->commands([
                $this->makeCommand(command: 'toggleBold'),
            ]);
    }
}
