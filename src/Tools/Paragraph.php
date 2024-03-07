<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Paragraph as ParagraphExtension;

class Paragraph extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-paragraph')
            ->label('Paragraph')
            ->extension('paragraph')
            ->commands([
                $this->makeCommand(command: 'setParagraph'),
            ])
            ->converterExtensions(new ParagraphExtension());
    }
}
