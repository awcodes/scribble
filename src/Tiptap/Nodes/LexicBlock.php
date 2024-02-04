<?php

namespace Awcodes\Scribble\Tiptap\Nodes;

use Awcodes\Scribble\Utils\BlockManager;
use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

class LexicBlock extends Node
{
    public static $name = 'lexicBlock';

    public function addAttributes(): array
    {
        return [
            'preview' => [
                'default' => null,
                'rendered' => false,
            ],
            'type' => [
                'default' => null,
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->getAttribute('data-type');
                },
                'renderHTML' => function ($attributes) {
                    return [
                        'data-type' => $attributes->type,
                    ];
                },
            ],
            'data' => [
                'default' => null,
                'parseHTML' => function ($DOMNode) {
                    return json_decode($DOMNode->getAttribute('data-data'), true);
                },
                'renderHTML' => function ($attributes) {
                    return [
                        'data-data' => json_encode($attributes->data, true),
                    ];
                },
            ],
        ];
    }

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'lexic-block',
            ],
        ];
    }

    public function getBlocks(): array
    {
        $customBlocks = $this->options['blocks'] ?? null;

        if (blank($customBlocks)) {
            return app(BlockManager::class)->getBlocks();
        }

        return collect($customBlocks)
            ->mapWithKeys(function (string $block): array {
                $blockInstance = app($block);

                return [$blockInstance->getIdentifier() => $blockInstance];
            })
            ->all();
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        $blocks = $this->getBlocks();
        $view = view(
            view: $blocks[$node->attrs->type]->rendered,
            data: json_decode(json_encode($node->attrs->data), associative: true),
        )->render();

        return [
            'lexic-block',
            HTML::mergeAttributes($HTMLAttributes),
            'content' => $view,
        ];
    }
}
