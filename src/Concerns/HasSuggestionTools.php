<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasSuggestionTools
{
    protected array | Closure | null $suggestionTools = null;

    protected ?bool $withSuggestionDefaults = null;

    public function suggestionTools(array | Closure | bool $tools, bool $withDefaults = true): static
    {
        if ($tools) {
            $this->suggestionTools = $tools;
            $this->withSuggestionDefaults = $withDefaults;
        } else {
            $this->withSuggestionDefaults = false;
        }

        return $this;
    }

    public function getSuggestionTools(): array
    {
        if ($this->getProfile()) {
            $tools = app($this->getProfile())->suggestionTools() ?? [];
            $this->withSuggestionDefaults = false;
        } else {
            $tools = [...$this->evaluate($this->suggestionTools) ?? []];
        }


        if ($this->shouldIncludeSuggestionDefaults()) {
            $tools = array_merge($tools, $this->getDefaultSuggestionTools());
        }

        return $tools;
    }

    public function shouldIncludeSuggestionDefaults()
    {
        return $this->evaluate($this->withSuggestionDefaults) ?? true;
    }

    public function getDefaultSuggestionTools(): array
    {
        return app(ScribbleManager::class)->getTools([
            'details',
            'bullet-list',
            'ordered-list',
            'blockquote',
            'horizontal-rule',
        ])->toArray();
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
