<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;

class SimpleProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            'heading-two',
            'heading-three',
            'horizontal-rule',
            'bullet-list',
            'ordered-list',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'divider',
            'link',
            'media',
        ];
    }

    public static function suggestionTools(): array
    {
        return [
            'media',
            'bullet-list',
            'ordered-list',
            'horizontal-rule',
        ];
    }

    public static function toolbarTools(): array
    {
        return [
            'heading-two',
            'heading-three',
            'horizontal-rule',
            'bullet-list',
            'ordered-list',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'divider',
            'link',
            'media',
        ];
    }
}
