<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Tool;

class Link extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-link')
            ->label('Link')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'extendMarkRange', arguments: 'link'),
                $this->makeCommand(command: 'setLink'),
                $this->makeCommand(command: 'moveToEnd'),
            ]);
    }
}
