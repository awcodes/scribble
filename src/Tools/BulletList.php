<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\BulletList as BulletListExtension;

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
            ->converterExtensions(new BulletListExtension);
    }
}
