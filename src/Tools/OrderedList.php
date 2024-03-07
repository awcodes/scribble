<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\OrderedList as OrderedListExtension;

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
            ->converterExtensions(new OrderedListExtension());
    }
}
