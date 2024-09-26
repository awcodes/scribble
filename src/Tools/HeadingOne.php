<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingOne extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-one')
            ->label('Heading 1')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 1])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 1]),
            ])
            ->converterExtensions(new HeadingExtension);
    }
}
