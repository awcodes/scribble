<?php

namespace Awcodes\Scribble\Enums;

enum ToolType: string
{
    case Block = 'block';
    case Command = 'command';
    case Divider = 'divider';
    case Event = 'event';
    case Modal = 'modal';
    case StaticBlock = 'static';
}
