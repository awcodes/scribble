<?php

namespace Awcodes\Scribble\Tiptap\Nodes;

use Awcodes\Scribble\Helpers;
use Tiptap\Core\Node;

class ScribbleBlock extends Node
{
    public static $name = 'scribbleBlock';

    public function addAttributes(): array
    {
        return [
            'id' => [
                'default' => null,
            ],
            'type' => [
                'default' => 'block',
            ],
            'identifier' => [
                'default' => null,
            ],
            'values' => [
                'default' => [],
            ],
        ];
    }

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'scribble-block',
                'getAttrs' => function ($DOMNode) {
                    return json_decode($DOMNode->nodeValue, true);
                },
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        $data = $HTMLAttributes;
        $view = null;

        if ($data) {
            foreach (Helpers::getToolClasses() as $block) {
                $block = new $block();

                if ($block->getIdentifier() === $data['identifier']) {
                    $view = $block->getRenderedView((array) $data['values']);
                }
            }
        }

        return [
            'content' => '<div class="scribble-block">' . $view . '</div>',
        ];
    }
}
