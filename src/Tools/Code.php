<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

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
            ->converterExtension(\Tiptap\Marks\Code::class);
    }
}
