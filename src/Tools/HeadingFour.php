<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingFour extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-heading-four')
            ->label('Heading 4')
            ->extension('heading')
            ->active(extension: 'heading', attrs: ['level' => 4])
            ->commands([
                $this->makeCommand(command: 'toggleHeading', arguments: ['level' => 4]),
            ])
            ->converterExtension(\Tiptap\Nodes\Heading::class);
    }
}
