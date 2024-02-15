<?php

namespace Awcodes\Scribble\Concerns;

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
        return [
            Tools\Grid::class,
            Tools\Media::class,
            Tools\Details::class,
            Tools\BulletList::class,
            Tools\OrderedList::class,
            Tools\Blockquote::class,
            Tools\HorizontalRule::class,
        ];
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
                        ...$this->formatTool($groupBlock),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tools[] = [
                    ...$this->formatTool($tool),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $tools;
    }
}
