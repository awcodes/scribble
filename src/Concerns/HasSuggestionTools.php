<?php

namespace Awcodes\Scribble\Concerns;

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

        return $tools;
    }

    /**
     * @throws Exception
     */
    public function getSuggestionToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getSuggestionTools() as $tool) {
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
