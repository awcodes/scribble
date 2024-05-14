<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasSuggestionTools
{
    protected array | Closure | bool | null $suggestionTools = null;

    public function suggestionTools(array | Closure | bool $tools): static
    {
        $this->suggestionTools = $tools;

        return $this;
    }

    public function getSuggestionTools(): array
    {
        $tools = $this->evaluate($this->suggestionTools);

        if (! is_null($tools) && $tools === false) {
            return [];
        }

        if (empty($tools)) {
            $tools = $this->getProfile()
                ? app($this->getProfile())::suggestionTools()
                : DefaultProfile::suggestionTools();
        }

        return Scribble::getTools($tools)->toArray();
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
