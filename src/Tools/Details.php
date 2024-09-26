<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\Details as DetailsExtension;
use Awcodes\Scribble\Tiptap\Nodes\DetailsContent as DetailsContentExtension;
use Awcodes\Scribble\Tiptap\Nodes\DetailsSummary as DetailsSummaryExtension;

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
            ->converterExtensions([
                new DetailsExtension,
                new DetailsContentExtension,
                new DetailsSummaryExtension,
            ]);
    }
}
