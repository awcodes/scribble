<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Subscript as SubscriptExtension;

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
            ->converterExtensions(new SubscriptExtension);
    }
}
