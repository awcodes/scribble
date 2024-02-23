<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class HeadingFour extends Tool
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
            ]);
    }
}
