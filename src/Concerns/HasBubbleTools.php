<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Wrappers\Group;
use Exception;

trait HasBubbleTools
{
    public function getBubbleTools(): array
    {
        $tools = $this->getProfile()
            ? app($this->getProfile())::bubbleTools() ?? []
            : DefaultProfile::bubbleTools();

        if (! isset($tools['link'])) {
            $tools['link'] = Link::make()->hidden();
        }

        $defaults = app(ScribbleManager::class)->getRegisteredTools()
            ->filter(fn (ScribbleTool $tool) => in_array($this->getProfile() ?? DefaultProfile::class, $tool->getBubbleTool()))
            ->all();

        return [...$tools, ...$defaults];
    }

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getBubbleTools() as $tool) {
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

        return $tools;
    }
}
