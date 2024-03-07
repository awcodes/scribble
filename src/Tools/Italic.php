<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Italic as ItalicExtension;

class Italic extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-italic')
            ->label('Italic')
            ->extension('italic')
            ->active(extension: 'italic')
            ->commands([
                $this->makeCommand(command: 'toggleItalic'),
            ])
            ->converterExtensions(new ItalicExtension());
    }
}
