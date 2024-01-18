<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBlocks;
use Awcodes\Scribble\Concerns\HasTools;
use Awcodes\Scribble\Wrappers\Group;
use Filament\Forms\Components\Field;

class Scribble extends Field
{
    use HasBlocks;
    use HasTools;

    protected string $view = 'scribble::scribble';

    public function getBlocksSchema(): array
    {
        return $this->getActionSchema($this->getBlocks());
    }

    public function getToolsSchema(): array
    {
        return $this->getActionSchema($this->getTools());
    }

    private function formatAction(ScribbleAction $action): array
    {
        return [
            'identifier' => $action::getIdentifier(),
            'extension' => $action::getExtension(),
            'icon' => $action::getIcon(),
            'label' => ucfirst($action::getLabel()),
            'description' => $action::getDescription(),
            'type' => $action::getType(),
            'action' => $action::getAction(),
            'actionArguments' => $action::getActionArguments(),
        ];
    }

    private function getActionSchema(array $actionsSchema): array
    {
        $actions = [];

        foreach ($actionsSchema as $action) {
            if ($action instanceof Group) {
                foreach ($action->getBlocks() as $groupBlock) {
                    $actions[] = [
                        ...$this->formatAction($groupBlock),
                        'group' => $action->getLabel(),
                    ];
                }
            }

            if (is_string($action)) {
                $action = app($action);

                $actions[] = [
                    ...$this->formatAction($action),
                    'group' => '',
                ];
            }
        }

        return $actions;
    }
}
