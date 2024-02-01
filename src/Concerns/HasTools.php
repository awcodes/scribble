<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
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
            ...$this->evaluate($this->tools) ?? [],
            Tools\Bold::class,
            Tools\Italic::class,
            Tools\BulletList::class,
            Tools\OrderedList::class,
            Tools\Code::class,
            Tools\Link::class,
            Group::make('Text')
                ->tools([
                    Tools\Underline::class,
                    Tools\Strike::class,
                    Tools\Superscript::class,
                    Tools\Subscript::class,
                    Tools\Paragraph::class,
                ]),
            Group::make('Alignment')
                ->tools([
                    Tools\AlignStart::class,
                    Tools\AlignCenter::class,
                    Tools\AlignEnd::class,
                    Tools\AlignJustify::class,
            ]),
            Tools\Grid::class,
            Tools\Media::class,
            Tools\Blockquote::class,
            Tools\HorizontalRule::class,
        ];
    }
}
