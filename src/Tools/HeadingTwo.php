<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingTwo extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-two')
            ->label('Heading 2')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 2])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 2]),
            ])
            ->converterExtension(\Tiptap\Nodes\Heading::class);
    }
}
