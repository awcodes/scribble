<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class Divider extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->type(ToolType::Divider);
    }
}
