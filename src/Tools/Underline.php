<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Underline extends ScribbleTool
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
