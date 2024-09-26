<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Code as CodeExtension;

class Code extends ScribbleTool
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
            ])
            ->converterExtensions(new CodeExtension);
    }
}
