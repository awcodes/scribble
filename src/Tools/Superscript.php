<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

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
            ->converterExtension(\Tiptap\Marks\Superscript::class);
    }
}
