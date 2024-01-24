<?php

namespace Awcodes\Scribble\Enums;

enum ToolType: string
{
    case Block = 'block';
    case Command = 'command';
    case Modal = 'modal';
    case StaticBlock = 'static';
}
