<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\MediaModal;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\Image as ImageExtension;

class Media extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-media')
            ->label('Media')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'setMedia'),
            ])
            ->optionsModal(MediaModal::class)
            ->converterExtensions(new ImageExtension());
    }
}
