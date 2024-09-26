<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingSix extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-six')
            ->label('Heading 6')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 6])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 6]),
            ])
            ->converterExtensions(new HeadingExtension);
    }
}
