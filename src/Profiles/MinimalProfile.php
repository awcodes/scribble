<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;

class MinimalProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ];
    }

    public static function suggestionTools(): array
    {
        return [];
    }

    public static function toolbarTools(): array
    {
        return [
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ];
    }
}
