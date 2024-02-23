<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Underline extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-underline')
            ->label('Underline')
            ->extension('underline')
            ->active(extension: 'underline')
            ->commands([
                $this->makeCommand(command: 'toggleUnderline'),
            ]);
    }
}
