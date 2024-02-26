<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Paragraph extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-paragraph')
            ->label('Paragraph')
            ->extension('paragraph')
            ->commands([
                $this->makeCommand(command: 'setParagraph'),
            ]);
    }
}
