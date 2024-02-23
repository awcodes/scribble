<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Tool;

class Media extends Tool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-media')
            ->label('Media')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'setImage'),
            ]);
    }
}
