<?php

namespace Awcodes\Scribble\Tiptap\Nodes;

use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

class Grid extends Node
{
    public static $name = 'grid';

    public function addOptions(): array
    {
        return [
            'HTMLAttributes' => [
                'class' => 'lexic-grid',
            ],
        ];
    }

    public function addAttributes(): array
    {
        return [
            'data-type' => [
                'default' => 'responsive',
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->getAttribute('data-type');
                },
            ],
            'data-cols' => [
                'default' => '2',
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->getAttribute('data-cols');
                },
                'renderHTML' => function ($attributes) {
                    $attributes = (array) $attributes;

                    return [
                        'data-cols' => $attributes['data-cols'],
                        'style' => 'grid-template-columns: repeat(' . $attributes['data-cols'] . ', 1fr);',
                    ];
                },
            ],
            'data-stack-at' => [
                'default' => 'md',
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->getAttribute('data-stack-at');
                },
            ],
        ];
    }

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'div',
                'getAttrs' => function ($DOMNode) {
                    return str_contains($DOMNode->getAttribute('class'), 'lexic-grid')
                        && ! str_contains($DOMNode->getAttribute('class'), '__column');
                },
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        return [
            'div',
            HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes),
            0,
        ];
    }
}
