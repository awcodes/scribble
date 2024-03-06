<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\LinkModal;
use Awcodes\Scribble\ScribbleTool;

class Link extends ScribbleTool
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
            ])
            ->optionsModal(component: LinkModal::class)
            ->converterExtension(\Awcodes\Scribble\Tiptap\Marks\Link::class);
    }
}
