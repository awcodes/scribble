<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\ScribbleFacade;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Wrappers\Group;
use Exception;

trait HasSuggestionTools
{
    public function getSuggestionTools(): array
    {
        if ($this->getProfile()) {
            $tools = app($this->getProfile())::suggestionTools() ?? [];
        } else {
            $tools = DefaultProfile::suggestionTools();
        }

        return ScribbleFacade::getTools($tools)->toArray();
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
