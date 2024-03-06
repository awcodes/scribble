<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class Subscript extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-subscript')
            ->label('Subscript')
            ->extension('subscript')
            ->active(extension: 'subscript')
            ->commands([
                $this->makeCommand(command: 'toggleSubscript'),
            ])
            ->converterExtension(\Tiptap\Marks\Subscript::class);
    }
}
