<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class OrderedList extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-list-ordered')
            ->label('Ordered list')
            ->extension('orderedList')
            ->active(extension: 'orderedList')
            ->commands([
                $this->makeCommand(command: 'toggleOrderedList'),
            ])
            ->converterExtension(\Tiptap\Nodes\OrderedList::class);
    }
}
