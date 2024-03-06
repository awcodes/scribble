<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Extensions\TextAlignExtension;

class AlignJustify extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-align-justify')
            ->label('Align Justify')
            ->extension('textAlign')
            ->commands([
                $this->makeCommand(command: 'setTextAlign', arguments: 'justify'),
            ])
            ->converterExtension(TextAlignExtension::class)
            ->converterExtensionOptions([
                'types' => ['heading', 'paragraph'],
            ]);
    }
}
