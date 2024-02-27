<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Blockquote extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-blockquote')
            ->label('Blockquote')
            ->extension('blockquote')
            ->active(extension: 'blockquote')
            ->commands([
                $this->makeCommand(command: 'toggleBlockquote'),
            ]);
    }
}
