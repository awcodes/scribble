<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\GridModal;
use Awcodes\Scribble\Tool;

class Grid extends Tool
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
            ->optionsModal(GridModal::class);
    }
}
