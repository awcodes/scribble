<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\ScribbleProfile;

class MinimalProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return app(ScribbleManager::class)->getTools([
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ])->toArray();
    }

    public static function suggestionTools(): array
    {
        return [];
    }

    public static function toolbarTools(): array
    {
        return app(ScribbleManager::class)->getTools([
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ])->toArray();
    }
}
