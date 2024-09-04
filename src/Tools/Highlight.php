<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Highlight as HighlightExtension;

class Highlight extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-highlight')
            ->label('Highlight')
            ->extension('highlight')
            ->commands([
                $this->makeCommand(command: 'toggleHighlight'),
            ])
            ->converterExtensions(new HighlightExtension());
    }
}
