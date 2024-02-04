<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBubbleTools;
use Awcodes\Scribble\Concerns\HasSuggestionTools;
use Awcodes\Scribble\Concerns\HasToolbarTools;
use Awcodes\Scribble\Wrappers\Group;
use Exception;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;

class Scribble extends Field
{
    use HasBubbleTools;
    use HasPlaceholder;
    use HasSuggestionTools;
    use HasToolbarTools;

    protected string $view = 'scribble::scribble';

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getBubbleTools() as $tool) {
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

    /**
     * @throws Exception
     */
    public function getToolbarToolsSchema(): array
    {
        $tools = [];

        if ($this->shouldRenderToolbar()) {

            foreach ($this->getToolbarTools() as $tool) {
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
        }

        return $tools;
    }

    /**
     * @throws Exception
     */
    private function formatTool(ScribbleTool | string $tool): array
    {
        if (is_string($tool)) {
            $tool = new $tool();
        }

        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $tool->getIdentifier(),
            'extension' => $tool->getExtension(),
            'activeAttributes' => $tool->getActiveAttributes(),
            'icon' => $tool->getIcon(),
            'label' => ucfirst($tool->getLabel()),
            'description' => $tool->getDescription(),
            'type' => $tool->getType()->value,
            'commands' => $tool->getCommands(),
            'isHidden' => $tool->isHidden(),
        ];
    }
}
