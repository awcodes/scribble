<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasToolbarTools
{
    protected bool | Closure | null $renderToolbar = false;

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
            if ($this->getProfile()) {
                $tools = app($this->getProfile())::toolbarTools() ?? [];
            } else {
                $tools = DefaultProfile::toolbarTools();
            }

            if (! isset($tools['link'])) {
                $tools['link'] = Link::make()->hidden();
            }

            return $tools;
        }

        return [];
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
                    foreach ($tool->getTools() as $groupTool) {
                        $groupTool->statePath($this->getStatePath());

                        $tools[] = [
                            ...$groupTool->toArray(),
                            'group' => $tool->getLabel(),
                            'groupLabel' => str($tool->getLabel())->title(),
                        ];
                    }
                } else {
                    $tool->statePath($this->getStatePath());

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
