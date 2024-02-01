<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasTools;
use Awcodes\Scribble\Wrappers\Group;
use Exception;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;

class Scribble extends Field
{
    use HasPlaceholder;
    use HasTools;

    protected string $view = 'scribble::scribble';

    /**
     * @throws Exception
     */
    public function getToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getTools() as $tool) {
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
    private function formatTool(ScribbleTool | string $tool): array
    {
        if (is_string($tool)) {
            $tool = app($tool);
        }

        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $tool::getIdentifier(),
            'extension' => $tool::getExtension(),
            'icon' => $tool::getIcon(),
            'label' => ucfirst($tool::getLabel()),
            'description' => $tool::getDescription(),
            'type' => $tool::getType()->value,
            'commands' => $tool::getCommands(),
            'bubble' => $tool::shouldShowInBubbleMenu(),
            'suggestion' => $tool::shouldShowInSuggestionMenu(),
        ];
    }
}
