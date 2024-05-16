<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Helpers;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Link;
use Closure;
use Exception;

trait HasBubbleTools
{
    protected array | Closure | bool | null $bubbleTools = null;

    public function bubbleTools(array | Closure | bool $tools): static
    {
        $this->bubbleTools = $tools;

        return $this;
    }

    public function getBubbleTools(): array
    {
        $tools = $this->evaluate($this->bubbleTools);

        if (! is_null($tools) && $tools === false) {
            return [];
        }

        if (empty($tools)) {
            $tools = $this->getProfile()
                ? app($this->getProfile())::bubbleTools()
                : DefaultProfile::bubbleTools();
        }


        $tools = Scribble::getTools($tools)->toArray();

        if (! isset($tools['link'])) {
            $tools['link'] = Link::make()->hidden();
        }

        $defaults = Scribble::getRegisteredTools()
            ->filter(fn (ScribbleTool $tool) => in_array($this->getProfile() ?? DefaultProfile::class, $tool->getBubbleTool()))
            ->all();

        return [...$tools, ...$defaults];
    }

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        return Helpers::getToolsSchema($this->getBubbleTools(), $this->getStatePath());
    }
}
