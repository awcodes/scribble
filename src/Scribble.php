<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBlocks;
use Awcodes\Scribble\Wrappers\Group;
use Filament\Forms\Components\Field;

class Scribble extends Field
{
    use HasBlocks;

    protected string $view = 'scribble::scribble';

    public function getSchema(): array
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
}
