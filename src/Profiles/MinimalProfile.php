<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Awcodes\Scribble\Tools\Bold;
use Awcodes\Scribble\Tools\BulletList;
use Awcodes\Scribble\Tools\Italic;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Tools\OrderedList;
use Awcodes\Scribble\Tools\Paragraph;

class MinimalProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            Paragraph::class,
            Bold::class,
            Italic::class,
            Link::class,
            BulletList::class,
            OrderedList::class,
        ];
    }

    public static function suggestionTools(): array
    {
        return [];
    }

    public static function toolbarTools(): array
    {
        return [
            Paragraph::class,
            Bold::class,
            Italic::class,
            Link::class,
            BulletList::class,
            OrderedList::class,
        ];
    }
}
