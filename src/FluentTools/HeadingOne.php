<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingOne extends Tool
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
            ]);
    }
}
