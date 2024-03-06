<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\TextAlignExtension;

class AlignEnd extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-end')
            ->label('Align End')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'end'),
            ])
            ->converterExtension(TextAlignExtension::class)
            ->converterExtensionOptions([
                'types' => ['heading', 'paragraph'],
            ]);
    }
}
