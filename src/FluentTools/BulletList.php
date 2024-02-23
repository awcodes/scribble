<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Tool;

class BulletList extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-list-unordered')
            ->label('Bullet list')
            ->extension('bulletList')
            ->defaultBubbleTool()
            ->defaultToolbarTool()
            ->defaultSuggestionTool()
            ->active(extension: 'bulletList')
            ->commands([
                $this->makeCommand(command: 'toggleBulletList'),
            ]);
    }
}
