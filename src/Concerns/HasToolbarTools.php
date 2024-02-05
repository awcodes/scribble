<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

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

    public function shouldRenderToolbar(): bool
    {
        return $this->evaluate($this->renderToolbar);
    }

    /**
     * @throws Exception
     */
    public function getToolbarToolsSchema(): array
    {
        $tools = [];

        if ($this->shouldRenderToolbar()) {

            foreach ($this->getToolbarTools() as $tool) {
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
        }

        return $tools;
    }
}
