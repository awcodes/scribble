<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class Blockquote extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-blockquote')
            ->label('Blockquote')
            ->extension('blockquote')
            ->defaultToolbarTool()
            ->defaultSuggestionTool()
            ->active(extension: 'blockquote')
            ->commands([
                $this->makeCommand(command: 'toggleBlockquote'),
            ]);
    }
}
