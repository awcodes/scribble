<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\ScribbleFacade;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Wrappers\Group;
use Exception;

trait HasSuggestionTools
{
    public function getSuggestionTools(): array
    {
        $tools = $this->getProfile()
            ? app($this->getProfile())::suggestionTools() ?? []
            : DefaultProfile::suggestionTools();

        $tools = ScribbleFacade::getTools($tools)->toArray();

        $defaults = app(ScribbleManager::class)->getRegisteredTools()
            ->filter(fn (ScribbleTool $tool) => in_array($this->getProfile() ?? DefaultProfile::class, $tool->getSuggestionTool()))
            ->all();

        return [...$tools, ...$defaults];
    }

    /**
     * @throws Exception
     */
    public function getSuggestionToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getSuggestionTools() as $tool) {
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
