<?php

namespace Awcodes\Scribble\Tiptap\Extensions;

use Tiptap\Core\Extension;

class IdExtension extends Extension
{
    public static $name = 'idExtension';

    public function addGlobalAttributes(): array
    {
        return [
            [
                'types' => [
                    'heading',
                    'link',
                ],
                'attributes' => [
                    'id' => [
                        'default' => null,
                        'parseHTML' => function ($DOMNode) {
                            return $DOMNode->hasAttribute('id') ? $DOMNode->getAttribute('id') : null;
                        },
                        'renderHTML' => function ($attributes) {
                            if (! property_exists($attributes, 'id')) {
                                return null;
                            }

                            return [
                                'id' => $attributes->id,
                            ];
                        },
                    ],
                ],
            ],
        ];
    }
}
