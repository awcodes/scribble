<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Blocks;
use Closure;

trait HasBlocks
{
    protected array | Closure | null $blocks = null;

    public function blocks(array | Closure | null $blocks): static
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function getBlocks(): array
    {
        return [
            Blocks\BulletList::class,
            Blocks\OrderedList::class,
            Blocks\Blockquote::class,
            Blocks\HorizontalRule::class,
            ...$this->evaluate($this->blocks) ?? [],
        ];
    }
}
