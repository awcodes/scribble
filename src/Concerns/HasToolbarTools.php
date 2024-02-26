<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\FluentTools\Link;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasToolbarTools
{
    protected array | Closure | null $toolbarTools = null;

    protected bool | Closure | null $renderToolbar = false;

    protected ?bool $withToolbarDefaults = null;

    public function toolbarTools(array | Closure | bool $tools, bool $withDefaults = true): static
    {
        if ($tools) {
            $this->toolbarTools = $tools;
            $this->withToolbarDefaults = $withDefaults;
        } else {
            $this->withToolbarDefaults = false;
        }

        return $this;
    }

    public function renderToolbar(bool | Closure | null $render = true): static
    {
        $this->renderToolbar = $render;

        return $this;
    }

    public function getToolbarTools(): array
    {
        if ($this->shouldRenderToolbar()) {
            if ($this->getProfile()) {
                $tools = app($this->getProfile())->toolbarTools() ?? [];
                $this->withToolbarDefaults = false;
            } else {
                $tools = [...$this->evaluate($this->toolbarTools) ?? []];
            }

            if ($this->shouldIncludeToolbarDefaults()) {
                $tools = array_merge($tools, $this->getDefaultToolbarTools());
            }

            if (! isset($tools['link'])) {
                $tools['link'] = Link::make()->hidden();
            }

            return $tools;
        }

        return [];
    }

    public function shouldIncludeToolbarDefaults()
    {
        return $this->evaluate($this->withToolbarDefaults) ?? true;
    }

    public function getDefaultToolbarTools(): array
    {
        return DefaultProfile::toolbarTools();
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
        }

        return $tools;
    }
}
