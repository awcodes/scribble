<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Actions;
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
            Actions\Bold::class,
            Actions\Italic::class,
            Actions\Underline::class,
            Actions\Strike::class,
            Actions\Superscript::class,
            Actions\Subscript::class,
            Actions\Paragraph::class,
            Actions\BulletList::class,
            Actions\OrderedList::class,
            Actions\Code::class,
            Actions\Link::class,
            Actions\AlignStart::class,
            Actions\AlignCenter::class,
            Actions\AlignEnd::class,
            Actions\AlignJustify::class,
            ...$this->evaluate($this->tools) ?? [],
        ];
    }
}
