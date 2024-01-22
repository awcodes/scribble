<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Actions;
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
            Actions\Media::class,
            Actions\BulletList::class,
            Actions\OrderedList::class,
            Actions\Blockquote::class,
            Actions\HorizontalRule::class,
            ...$this->evaluate($this->blocks) ?? [],
        ];
    }
}
