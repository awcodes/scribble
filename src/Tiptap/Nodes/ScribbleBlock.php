<?php

namespace Awcodes\Scribble\Tiptap\Nodes;

use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

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
        return [
            'scribble-block',
            json_encode($HTMLAttributes),
        ];
    }
}
