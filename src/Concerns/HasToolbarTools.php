<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;

trait HasToolbarTools
{
    protected array | Closure | null $toolbarTools = null;

    protected bool | Closure | null $renderToolbar = false;

    public function toolbarTools(array | Closure | null $tools): static
    {
        $this->toolbarTools = $tools;

        return $this;
    }

    public function renderToolbar(bool | Closure | null $render = true): static
    {
        $this->renderToolbar = $render;

        return $this;
    }

    public function getToolbarTools(): array
    {
        return [
            ...$this->evaluate($this->toolbarTools) ?? [],
            Group::make('Headings')
                ->tools([
                    Tools\HeadingOne::class,
                    Tools\HeadingTwo::class,
                    Tools\HeadingThree::class,
                ]),
            Group::make('Text')
                ->tools([
                    Tools\Bold::class,
                    Tools\Italic::class,
                    Tools\Underline::class,
                    Tools\Strike::class,
                    Tools\Superscript::class,
                    Tools\Subscript::class,
                    Tools\Paragraph::class,
                ]),
            Group::make('Blocks')
                ->tools([
                    Tools\BulletList::class,
                    Tools\OrderedList::class,
                    Tools\Code::class,
                    Tools\Link::class,
                ]),
            Group::make('Alignment')
                ->tools([
                    Tools\AlignStart::class,
                    Tools\AlignCenter::class,
                    Tools\AlignEnd::class,
                    Tools\AlignJustify::class,
                ]),
        ];
    }

    public function shouldRenderToolbar(): bool
    {
        return $this->evaluate($this->renderToolbar);
    }
}
