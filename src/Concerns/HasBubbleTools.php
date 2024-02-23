<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasBubbleTools
{
    protected array | Closure | null $bubbleTools = null;

    protected ?bool $withBubbleDefaults = null;

    public function bubbleTools(array | Closure | bool $tools, bool $withDefaults = true): static
    {
        if ($tools) {
            $this->bubbleTools = $tools;
            $this->withBubbleDefaults = $withDefaults;
        } else {
            $this->withBubbleDefaults = false;
        }

        return $this;
    }

    public function getBubbleTools(): array
    {
        if ($this->getProfile()) {
            $tools = app($this->getProfile())->bubbleTools() ?? [];
            $this->withBubbleDefaults = false;
        } else {
            $tools = [...$this->evaluate($this->bubbleTools) ?? []];
        }

        if ($this->shouldIncludeBubbleDefaults()) {
            $tools = array_merge($tools, $this->getDefaultBubbleTools());
        }

        return array_merge(
            $tools,
//            [(new Tools\Link())->hidden()]
        );
    }

    public function shouldIncludeBubbleDefaults()
    {
        return $this->evaluate($this->withBubbleDefaults) ?? true;
    }

    public function getDefaultBubbleTools(): array
    {
        return app(ScribbleManager::class)->getTools([
            'heading-two',
            'heading-three',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'strike',
            'subscript',
            'superscript',
            'divider',
            'bullet-list',
            'ordered-list',
            'divider',
            'align-start',
            'align-center',
            'align-end',
        ])->toArray();
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
                        ...$groupBlock->toArray(),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tools[] = [
                    ...$tool->toArray(),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $tools;
    }
}
