<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasTools;
use Awcodes\Scribble\Wrappers\Group;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;

class Scribble extends Field
{
    use HasTools;
    use HasPlaceholder;

    protected string $view = 'scribble::scribble';

    public function getToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getTools() as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupBlock) {
                    $tools[] = [
                        ...$this->formatTool($groupBlock),
                        'group' => $tool->getLabel(),
                    ];
                }
            }

            if (is_string($tool)) {
                $tool = app($tool);

                $tools[] = [
                    ...$this->formatTool($tool),
                    'group' => '',
                ];
            }
        }

        return $tools;
    }

    private function formatTool(ScribbleTool $action): array
    {
        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $action::getIdentifier(),
            'extension' => $action::getExtension(),
            'icon' => $action::getIcon(),
            'label' => ucfirst($action::getLabel()),
            'description' => $action::getDescription(),
            'type' => $action::getType(),
            'command' => $action::getCommand(),
            'commandArguments' => $action::getCommandArguments(),
            'bubble' => $action::shouldShowInBubbleMenu(),
            'suggestion' => $action::shouldShowInSuggestionMenu(),
        ];
    }
}
