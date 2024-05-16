<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Helpers;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleTool;
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

        $tools = Scribble::getTools($tools)->toArray();

        $defaults = Scribble::getRegisteredTools()
            ->filter(fn (ScribbleTool $tool) => in_array($this->getProfile() ?? DefaultProfile::class, $tool->getSuggestionTool()))
            ->all();

        return [...$tools, ...$defaults];
    }

    /**
     * @throws Exception
     */
    public function getSuggestionToolsSchema(): array
    {
        return Helpers::getToolsSchema($this->getSuggestionTools(), $this->getStatePath());
    }
}
