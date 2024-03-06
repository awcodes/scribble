<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\DetailsContent;
use Awcodes\Scribble\Tiptap\Nodes\DetailsSummary;

class Details extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-details')
            ->label('Details')
            ->extension('details')
            ->active(extension: 'details')
            ->commands([
                $this->makeCommand(command: 'setDetails'),
            ])
            ->converterExtension([
                \Awcodes\Scribble\Tiptap\Nodes\Details::class,
                DetailsSummary::class,
                DetailsContent::class,
            ]);
    }
}
