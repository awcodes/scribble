<?php

namespace Awcodes\Scribble\Concerns\Tools;

trait HasIcon
{
    protected ?string $icon = null;

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        $icon = $this->evaluate($this->icon) ?? 'heroicon-o-cube';
        $html = svg($icon)->toHtml();

        if (! str($html)->contains('title')) {
            $html = str($html)->replace('</svg', '<title>' . $this->getLabel() . '</title></svg');
        }

        return $html;
    }
}
