<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\FluentTools;
use Filament\Support\Components\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ScribbleManager extends Component
{
    protected array | null $tools = null;

    protected array | null $customTools = null;

    public function registerCustomTools(array $tools): static
    {
        $this->customTools = $tools;

        return $this;
    }

    public function tools(array $tools): static
    {
        $this->tools = $tools;
        return $this;
    }

    public function getRegisteredTools(): Collection
    {
        return collect([...$this->tools ?? $this->getDefaultTools(), ...$this->customTools ?? []])
            ->mapWithKeys(function ($tool) {
                return [$tool->getIdentifier() => $tool];
            });
    }

    public function getTools(array | string $tools): Collection
    {
        $tls = collect();

        $tools = Arr::wrap($tools);

        foreach ($tools as $tool) {
            $tls->push($this->getRegisteredTools()->only($tool)->sole());
        }

        return $tls;
    }

    public function getDefaultTools(): array
    {
        return [
            FluentTools\AlignCenter::make(),
            FluentTools\AlignEnd::make(),
            FluentTools\AlignJustify::make(),
            FluentTools\AlignStart::make(),
            FluentTools\Blockquote::make(),
            FluentTools\Bold::make(),
            FluentTools\BulletList::make(),
            FluentTools\Code::make(),
            FluentTools\Details::make(),
            FluentTools\Divider::make(),
            FluentTools\HeadingFive::make(),
            FluentTools\HeadingFour::make(),
            FluentTools\HeadingOne::make(),
            FluentTools\HeadingSix::make(),
            FluentTools\HeadingThree::make(),
            FluentTools\HeadingTwo::make(),
            FluentTools\HorizontalRule::make(),
            FluentTools\Italic::make(),
            FluentTools\OrderedList::make(),
            FluentTools\Paragraph::make(),
            FluentTools\Strike::make(),
            FluentTools\Subscript::make(),
            FluentTools\Superscript::make(),
            FluentTools\Underline::make(),
        ];
    }
}
