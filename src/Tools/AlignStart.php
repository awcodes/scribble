<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\TextAlignExtension;

class AlignStart extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-start')
            ->label('Align Start')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'start'),
            ])
            ->converterExtensions(new TextAlignExtension(['types' => ['heading', 'paragraph']]));
    }
}
