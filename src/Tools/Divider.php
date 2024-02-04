<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class Divider extends ScribbleTool
{
    protected string $label = 'Divider';

    public function getType(): ToolType
    {
        return ToolType::Divider;
    }
}
