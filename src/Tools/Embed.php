<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\EmbedModal;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\Embed as EmbedExtension;

class Embed extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-embed')
            ->label('Embed')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'setEmbed'),
            ])
            ->optionsModal(component: EmbedModal::class)
            ->converterExtensions(new EmbedExtension());
    }
}
