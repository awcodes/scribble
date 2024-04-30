<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\TableModal;
use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\Table as TableExtension;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;

class Table extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-table')
            ->label('Table')
            ->type(ToolType::Modal)
            ->extension('table')
            ->active(extension: 'table')
            ->commands([
                $this->makeCommand(command: 'insertTable'),
            ])
            ->optionsModal(TableModal::class)
            ->converterExtensions([
                new TableExtension(),
                new TableRow(),
                new TableCell(),
                new TableHeader(),
            ]);
    }
}
