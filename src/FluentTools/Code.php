<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Code extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-code')
            ->label('Code')
            ->extension('code')
            ->active(extension: 'code')
            ->commands([
                $this->makeCommand(command: 'toggleCode'),
            ]);
    }
}
