<?php

namespace Awcodes\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;

class DefaultProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            'heading-two',
            'heading-three',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'strike',
            'subscript',
            'superscript',
            'divider',
            'link',
            'bullet-list',
            'ordered-list',
            'divider',
            'align-start',
            'align-center',
            'align-end',
        ];
    }

    public static function suggestionTools(): array
    {
        return [
            'grid',
            'details',
            'media',
            'bullet-list',
            'ordered-list',
            'blockquote',
            'horizontal-rule',
        ];
    }

    public static function toolbarTools(): array
    {
        return [
            'heading-two',
            'heading-three',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'strike',
            'subscript',
            'superscript',
            'divider',
            'link',
            'media',
            'bullet-list',
            'ordered-list',
            'details',
            'grid',
            'blockquote',
            'horizontal-rule',
            'divider',
            'align-start',
            'align-center',
            'align-end',
        ];
    }
}
