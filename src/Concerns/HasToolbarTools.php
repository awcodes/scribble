<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Helpers;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Link;
use Closure;
use Exception;

trait HasToolbarTools
{
    protected bool | Closure | null $renderToolbar = false;

    protected array | Closure | bool | null $toolbarTools = null;

    public function toolbarTools(array | Closure | bool $tools): static
    {
        $this->toolbarTools = $tools;

        return $this;
    }

    public function renderToolbar(bool | Closure | null $render = true): static
    {
        $this->renderToolbar = $render;

        return $this;
    }

    public function shouldRenderToolbar(): bool
    {
        return $this->evaluate($this->renderToolbar);
    }

    public function getToolbarTools(): array
    {
        if ($this->shouldRenderToolbar()) {
            $tools = $this->evaluate($this->toolbarTools);

            if (! is_null($tools) && $tools === false) {
                return [];
            }

            if (empty($tools)) {
                $tools = $this->getProfile()
                    ? app($this->getProfile())::toolbarTools()
                    : DefaultProfile::toolbarTools();
            }

            $tools = Scribble::getTools($tools)->toArray();

            if (! isset($tools['link'])) {
                $tools['link'] = Link::make()->hidden();
            }

            $defaults = Scribble::getRegisteredTools()
                ->filter(fn (ScribbleTool $tool) => in_array($this->getProfile() ?? DefaultProfile::class, $tool->getToolbarTool()))
                ->all();

            return [...$tools, ...$defaults];
        }

        return [];
    }

    /**
     * @throws Exception
     */
    public function getToolbarToolsSchema(): array
    {
        if ($this->shouldRenderToolbar()) {
            return Helpers::getToolsSchema($this->getToolbarTools(), $this->getStatePath());
        }

        return [];
    }
}
