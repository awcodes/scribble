<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingFive extends Tool
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
            ]);
    }
}
