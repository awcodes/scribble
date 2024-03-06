<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\GridModal;
use Awcodes\Scribble\ScribbleTool;

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
            ->converterExtension([
                \Awcodes\Scribble\Tiptap\Nodes\Grid::class,
                \Awcodes\Scribble\Tiptap\Nodes\GridColumn::class,
            ]);
    }
}
