<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Livewire\SourceCodeModal;
use Awcodes\Scribble\ScribbleTool;

class SourceCode extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-code-source')
            ->identifier('sourceCode')
            ->label('Source Code')
            ->type(ToolType::Modal)
            ->optionsModal(SourceCodeModal::class);
    }
}
