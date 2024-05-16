<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Awcodes\Scribble\Tools\AlignCenter;
use Awcodes\Scribble\Tools\AlignEnd;
use Awcodes\Scribble\Tools\AlignStart;
use Awcodes\Scribble\Tools\Blockquote;
use Awcodes\Scribble\Tools\Bold;
use Awcodes\Scribble\Tools\BulletList;
use Awcodes\Scribble\Tools\Details;
use Awcodes\Scribble\Tools\Divider;
use Awcodes\Scribble\Tools\Grid;
use Awcodes\Scribble\Tools\HeadingThree;
use Awcodes\Scribble\Tools\HeadingTwo;
use Awcodes\Scribble\Tools\HorizontalRule;
use Awcodes\Scribble\Tools\Italic;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Tools\Media;
use Awcodes\Scribble\Tools\OrderedList;
use Awcodes\Scribble\Tools\Paragraph;
use Awcodes\Scribble\Tools\Strike;
use Awcodes\Scribble\Tools\Subscript;
use Awcodes\Scribble\Tools\Superscript;

class DefaultProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            Paragraph::class,
            HeadingTwo::class,
            HeadingThree::class,
            Bold::class,
            Italic::class,
            Strike::class,
            Subscript::class,
            Superscript::class,
            Divider::class,
            Link::class,
            BulletList::class,
            OrderedList::class,
            Divider::class,
            AlignStart::class,
            AlignCenter::class,
            AlignEnd::class,
        ];
    }

    public static function suggestionTools(): array
    {
        return [
            Grid::class,
            Details::class,
            Media::class,
            BulletList::class,
            OrderedList::class,
            Blockquote::class,
            HorizontalRule::class,
        ];
    }

    public static function toolbarTools(): array
    {
        return [
            Paragraph::class,
            HeadingTwo::class,
            HeadingThree::class,
            Bold::class,
            Italic::class,
            Strike::class,
            Subscript::class,
            Superscript::class,
            Divider::class,
            Link::class,
            Media::class,
            BulletList::class,
            OrderedList::class,
            Details::class,
            Grid::class,
            Blockquote::class,
            HorizontalRule::class,
            Divider::class,
            AlignStart::class,
            AlignCenter::class,
            AlignEnd::class,
        ];
    }
}
