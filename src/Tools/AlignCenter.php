<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\TextAlignExtension;

class AlignCenter extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-center')
            ->label('Align Center')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'center'),
            ])
            ->converterExtensions(new TextAlignExtension(['types' => ['heading', 'paragraph']]));
    }
}
