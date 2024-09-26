<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\GridModal;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\Grid as GridExtension;
use Awcodes\Scribble\Tiptap\Nodes\GridColumn as GridColumnExtension;

class Grid extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-grid')
            ->label('Grid')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'insertGrid'),
            ])
            ->optionsModal(GridModal::class)
            ->converterExtensions([
                new GridExtension,
                new GridColumnExtension,
            ]);
    }
}
