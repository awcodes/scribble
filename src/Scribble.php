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
        $blocks = [];

        foreach ($this->getBlocks() as $block) {
            if ($block instanceof Group) {
                foreach ($block->getBlocks() as $groupBlock) {
                    $blocks[] = [
                        'name' => $groupBlock::getBlockName(),
                        'icon' => $groupBlock::getIcon(),
                        'title' => ucfirst($groupBlock::getTitle()),
                        'description' => $groupBlock::getDescription(),
                        'type' => $groupBlock::getType(),
                        'group' => $block->getLabel(),
                    ];
                }
            }

            if (is_string($block)) {
                $block = app($block);

                $blocks[] = [
                    'name' => $block::getBlockName(),
                    'icon' => $block::getIcon(),
                    'title' => ucfirst($block::getTitle()),
                    'description' => $block::getDescription(),
                    'type' => $block::getType(),
                    'group' => '',
                ];
            }
        }

        return $blocks;
    }

    public function getToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getTools() as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupTool) {
                    $tools[] = [
                        'name' => $groupTool::getToolName(),
                        'icon' => $groupTool::getIcon(),
                        'title' => ucfirst($groupTool::getTitle()),
                        'description' => $groupTool::getDescription(),
                        'type' => $groupTool::getType(),
                        'action' => $groupTool::getAction(),
                        'actionArguments' => $groupTool::getActionArguments(),
                        'group' => $tool->getLabel(),
                    ];
                }
            }

            if (is_string($tool)) {
                $tool = app($tool);

                $tools[] = [
                    'name' => $tool::getToolName(),
                    'icon' => $tool::getIcon(),
                    'title' => ucfirst($tool::getTitle()),
                    'description' => $tool::getDescription(),
                    'type' => $tool::getType(),
                    'action' => $tool::getAction(),
                    'actionArguments' => $tool::getActionArguments(),
                    'group' => '',
                ];
            }
        }

        return $tools;
    }
}
