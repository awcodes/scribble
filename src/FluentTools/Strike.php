<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Strike extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-strike')
            ->label('Strike')
            ->extension('strike')
            ->active(extension: 'strike')
            ->commands([
                $this->makeCommand(command: 'toggleStrike'),
            ]);
    }
}
