<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasBubbleTools
{
    protected array | Closure | null $bubbleTools = null;

    protected ?bool $withBubbleDefaults = null;

    public function bubbleTools(array | Closure | null $tools, bool $withDefaults = true): static
    {
        $this->bubbleTools = $tools;
        $this->withBubbleDefaults = $withDefaults;

        return $this;
    }

    public function getBubbleTools(): array
    {
        $tools = [...$this->evaluate($this->bubbleTools) ?? []];

        if ($this->shouldIncludeBubbleDefaults()) {
            $tools = array_merge($tools, $this->getDefaultBubbleTools());
        }

        return array_merge(
            $tools,
            [(new Tools\Link())->hidden()]
        );
    }

    public function shouldIncludeBubbleDefaults()
    {
        return $this->evaluate($this->withBubbleDefaults) ?? true;
    }

    public function getDefaultBubbleTools(): array
    {
        return [
            Tools\HeadingOne::class,
            Tools\HeadingTwo::class,
            Tools\HeadingThree::class,
            Tools\Divider::class,
            Tools\Bold::class,
            Tools\Italic::class,
            Tools\Underline::class,
            Tools\Strike::class,
            Tools\Superscript::class,
            Tools\Subscript::class,
            Tools\Paragraph::class,
            Tools\Divider::class,
            Tools\BulletList::class,
            Tools\OrderedList::class,
            Tools\Code::class,
            Tools\Link::class,
            Tools\Grid::class,
            Tools\Divider::class,
            Tools\AlignStart::class,
            Tools\AlignCenter::class,
            Tools\AlignEnd::class,
            Tools\AlignJustify::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getBubbleTools() as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupBlock) {
                    $tools[] = [
                        ...$this->formatTool($groupBlock),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tools[] = [
                    ...$this->formatTool($tool),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $tools;
    }
}
