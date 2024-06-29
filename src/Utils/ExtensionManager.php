<?php

namespace Awcodes\Scribble\Utils;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Tiptap\Extensions as CoreExtensions;
use Awcodes\Scribble\Tiptap\Marks as CoreMarks;
use Awcodes\Scribble\Tiptap\Nodes as CoreNodes;
use Tiptap\Marks;
use Tiptap\Nodes;

class ExtensionManager
{
    public function __construct(
        protected array $customExtensions = [],
    ) {
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function getCustomExtensions(): array
    {
        return Scribble::getRegisteredConverterExtensions()
            ->map(function ($extension) {
                return new $extension();
            })
            ->toArray();
    }

    public function getExtensions(): array
    {
        return [
            new Nodes\Document(),
            new Nodes\Blockquote(),
            new Nodes\BulletList(),
            new Nodes\HardBreak(),
            new Nodes\Heading(),
            new Nodes\HorizontalRule(),
            new Nodes\OrderedList(),
            new Nodes\Paragraph(),
            new Nodes\Text(),
            new Nodes\CodeBlockHighlight([
                'languageClassPrefix' => 'language-',
                'HTMLAttributes' => [
                    'class' => 'hljs'
                ]
            ]),
            new CoreExtensions\TextAlignExtension([
                'types' => ['heading', 'paragraph'],
            ]),
            new CoreExtensions\ClassExtension(),
            new CoreExtensions\IdExtension(),
            new CoreNodes\ListItem(),
            new CoreNodes\Media(),
            new CoreNodes\Details(),
            new CoreNodes\DetailsSummary(),
            new CoreNodes\DetailsContent(),
            new CoreNodes\Grid(),
            new CoreNodes\GridColumn(),
            new CoreNodes\MergeTag(),
            new CoreNodes\ScribbleBlock(),
            new Marks\TextStyle(),
            new Marks\Underline(),
            new Marks\Superscript(),
            new Marks\Subscript(),
            new Marks\Bold(),
            new Marks\Code(),
            new Marks\Italic(),
            new Marks\Strike(),
            new CoreMarks\Link(),
            ...$this->getCustomExtensions(),
        ];
    }
}
