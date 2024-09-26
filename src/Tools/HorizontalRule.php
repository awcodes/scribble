<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\HorizontalRule as HorizontalRuleExtension;

class HorizontalRule extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-hr')
            ->label('Horizontal Rule')
            ->extension('horizontalRule')
            ->commands([
                $this->makeCommand(command: 'setHorizontalRule'),
            ])
            ->converterExtensions(new HorizontalRuleExtension);
    }
}
