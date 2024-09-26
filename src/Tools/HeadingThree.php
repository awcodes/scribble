<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingThree extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-three')
            ->label('Heading 3')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 3])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 3]),
            ])
            ->converterExtensions(new HeadingExtension);
    }
}
