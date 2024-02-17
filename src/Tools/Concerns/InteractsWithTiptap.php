<?php

namespace Awcodes\Scribble\Tools\Concerns;

use Awcodes\Scribble\Enums\ToolType;
use Illuminate\Support\Str;

trait InteractsWithTiptap
{
    protected ?string $tiptapExtension = null;

    public function getTiptapExtension(): string
    {
        if (
            $this->getType() === ToolType::Block ||
            $this->getType() === ToolType::StaticBlock
        ) {
            return 'scribbleBlock';
        }

        return $this->evaluate($this->tiptapExtension)
            ?? (string) Str::of($this->getLabel())->title()->lcfirst()->replace(' ', '');
    }

    public function getCommands(): ?array
    {
        return null;
    }

    public function getActiveAttributes(): string | array
    {
        return [];
    }
}
