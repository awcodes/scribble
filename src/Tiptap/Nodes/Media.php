<?php

namespace Awcodes\Scribble\Tiptap\Nodes;

use Tiptap\Nodes\Image as BaseImage;

class Media extends BaseImage
{
    public static $name = 'media';

    public function addAttributes(): array
    {
        return [
            'src' => [
                'default' => null,
            ],
            'alt' => [
                'default' => null,
            ],
            'title' => [
                'default' => null,
            ],
            'width' => [
                'default' => null,
            ],
            'height' => [
                'default' => null,
            ],
            'lazy' => [
                'default' => false,
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->hasAttribute('loading') && $DOMNode->getAttribute('loading') === 'lazy';
                },
                'renderHTML' => function ($attributes) {
                    return $attributes->lazy
                        ? ['loading' => 'lazy']
                        : null;
                },
            ],
            'alignment' => [
                'default' => false,
                'renderHTML' => function ($attributes) {
                    $style = match ($attributes->alignment) {
                        'center' => 'margin-inline: auto;',
                        'end' => 'margin-inline-start: auto;',
                        default => null,
                    };

                    return [
                        'style' => $style
                    ];
                },
            ],
        ];
    }
}
