<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class BulletList extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-list-unordered')
            ->label('Bullet list')
            ->extension('bulletList')
            ->active(extension: 'bulletList')
            ->commands([
                $this->makeCommand(command: 'toggleBulletList'),
            ])
            ->converterExtension(\Tiptap\Nodes\BulletList::class);
    }
}
