<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Awcodes\Scribble\Tools\Bold;
use Awcodes\Scribble\Tools\BulletList;
use Awcodes\Scribble\Tools\Divider;
use Awcodes\Scribble\Tools\HeadingThree;
use Awcodes\Scribble\Tools\HeadingTwo;
use Awcodes\Scribble\Tools\HorizontalRule;
use Awcodes\Scribble\Tools\Italic;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Tools\Media;
use Awcodes\Scribble\Tools\OrderedList;
use Awcodes\Scribble\Tools\Paragraph;

class SimpleProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            Paragraph::class,
            HeadingTwo::class,
            HeadingThree::class,
            Divider::class,
            Bold::class,
            Italic::class,
            BulletList::class,
            OrderedList::class,
            HorizontalRule::class,
            Divider::class,
            Link::class,
            Media::class,
        ];
    }

    public static function suggestionTools(): array
    {
        return [
            Media::class,
            BulletList::class,
            OrderedList::class,
            HorizontalRule::class,
        ];
    }

    public static function toolbarTools(): array
    {
        return [
            Paragraph::class,
            HeadingTwo::class,
            HeadingThree::class,
            Divider::class,
            Bold::class,
            Italic::class,
            BulletList::class,
            OrderedList::class,
            HorizontalRule::class,
            Divider::class,
            Link::class,
            Media::class,
        ];
    }
}
