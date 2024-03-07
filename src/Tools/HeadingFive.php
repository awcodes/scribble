<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingFive extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-five')
            ->label('Heading 5')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 5])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 5]),
            ])
            ->converterExtensions(new HeadingExtension());
    }
}
