<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Closure;

trait HasTools
{
    protected array | Closure | null $tools = null;

    public function tools(array | Closure | null $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function getTools(): array
    {
        return [
            Tools\Bold::class,
            Tools\Italic::class,
            Tools\Underline::class,
            Tools\Strike::class,
            Tools\Superscript::class,
            Tools\Subscript::class,
            Tools\Paragraph::class,
            Tools\BulletList::class,
            Tools\OrderedList::class,
            Tools\Code::class,
            Tools\AlignStart::class,
            Tools\AlignCenter::class,
            Tools\AlignEnd::class,
            Tools\AlignJustify::class,
            ...$this->evaluate($this->tools) ?? [],
        ];
    }
}
