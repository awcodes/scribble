<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;

class HeadingFour extends ScribbleTool
{
    protected string $icon = 'scribble-heading-four';

    protected string $label = 'Heading 4';

    public function getExtension(): string
    {
        return 'heading';
    }

    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleHeading', 'arguments' => ['level' => 4]],
        ];
    }

    public function getActiveAttributes(): array
    {
        return [
            'level' => 4,
        ];
    }
}
