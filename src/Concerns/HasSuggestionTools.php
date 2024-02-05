<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasSuggestionTools
{
    protected array | Closure | null $suggestionTools = null;

    public function suggestionTools(array | Closure | null $tools): static
    {
        $this->suggestionTools = $tools;

        return $this;
    }

    public function getSuggestionTools(): array
    {
        return [
            ...$this->evaluate($this->suggestionTools) ?? [],
            Tools\Grid::class,
            Tools\Media::class,
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
