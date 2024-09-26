<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Underline as UnderlineExtension;

class Underline extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-underline')
            ->label('Underline')
            ->extension('underline')
            ->active(extension: 'underline')
            ->commands([
                $this->makeCommand(command: 'toggleUnderline'),
            ])
            ->converterExtensions(new UnderlineExtension);
    }
}
