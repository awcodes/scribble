<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Strike as StrikeExtension;

class Strike extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-strike')
            ->label('Strike')
            ->extension('strike')
            ->active(extension: 'strike')
            ->commands([
                $this->makeCommand(command: 'toggleStrike'),
            ])
            ->converterExtensions(new StrikeExtension());
    }
}
