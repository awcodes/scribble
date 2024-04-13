<?php

namespace Awcodes\Scribble\Concerns\Tools;

use Tiptap\Core\Extension;
use Tiptap\Core\Mark;
use Tiptap\Core\Node;

trait HasConverterExtensions
{
    protected Extension | Node | Mark | array | null $converterExtensions = null;

    /**
     * @param  Extension|Node|Mark|array<Extension|Node|Mark>  $extensions
     */
    public function converterExtensions(Extension | Node | Mark | array $extensions): static
    {
        $this->converterExtensions = $extensions;

        return $this;
    }

    public function getConverterExtensions(): Extension | Node | Mark | array | null
    {
        return $this->converterExtensions ?? null;
    }
}
