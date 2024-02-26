<?php

namespace Awcodes\Scribble\FluentTools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Tool;

class Divider extends Tool
{
    protected function setUp(): void
    {
        $this
            ->type(ToolType::Divider);
    }
}
