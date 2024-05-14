<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Wrappers\Group;
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
