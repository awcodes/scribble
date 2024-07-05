<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Awcodes\Scribble\Tools\AlignCenter;
use Awcodes\Scribble\Tools\AlignEnd;
use Awcodes\Scribble\Tools\AlignStart;
use Awcodes\Scribble\Tools\Blockquote;
use Awcodes\Scribble\Tools\Bold;
use Awcodes\Scribble\Tools\BulletList;
use Awcodes\Scribble\Tools\Code;
use Awcodes\Scribble\Tools\CodeBlock;
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
use Awcodes\Scribble\Tools\Table;

class DefaultProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            Bold::class,
            Italic::class,
            Strike::class,
            Subscript::class,
            Superscript::class,
            Link::class,
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
            CodeBlock::class,
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
            Table::class,
            Code::class,
            CodeBlock::class,
            Divider::class,
            AlignStart::class,
            AlignCenter::class,
            AlignEnd::class,
        ];
    }
}
