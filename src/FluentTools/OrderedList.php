<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class OrderedList extends Tool
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
            ]);
    }
}
