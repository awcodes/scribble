<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingSix extends Tool
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
            ]);
    }
}
