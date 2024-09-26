<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Superscript as SuperscriptExtension;

class Superscript extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-superscript')
            ->label('Superscript')
            ->extension('superscript')
            ->active(extension: 'superscript')
            ->commands([
                $this->makeCommand(command: 'toggleSuperscript'),
            ])
            ->converterExtensions(new SuperscriptExtension);
    }
}
