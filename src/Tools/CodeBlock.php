<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Tiptap\Nodes\CodeBlockHighlight as CodeBlockExtension;

class CodeBlock extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-code-block')
            ->label('Code Block')
            ->extension('codeBlockLowlight')
            ->active(extension: 'codeBlock')
            ->commands([
                $this->makeCommand(command: 'toggleCodeBlock'),
            ])
            ->converterExtensions(new CodeBlockExtension([
                'languageClassPrefix' => 'language-',
                'HTMLAttributes' => [
                    'class' => 'hljs'
                ]
            ]));
    }
}
