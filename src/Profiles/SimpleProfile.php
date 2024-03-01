<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\ScribbleProfile;

class SimpleProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return app(ScribbleManager::class)->getTools([
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
        ])->toArray();
    }

    public static function suggestionTools(): array
    {
        return app(ScribbleManager::class)->getTools([
            'media',
            'bullet-list',
            'ordered-list',
            'horizontal-rule',
        ])->toArray();
    }

    public static function toolbarTools(): array
    {
        return app(ScribbleManager::class)->getTools([
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
        ])->toArray();
    }
}
