<?php

namespace Awcodes\Scribble\Utils;

use Awcodes\Scribble\Enums\ContentType;
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\Helpers;
use League\HTMLToMarkdown\HtmlConverter;
use stdClass;
use Tiptap\Editor;

class Converter
{
    protected Editor $editor;

    public function __construct(
        public string | array | stdClass | null $content = null,
        public ?ExtensionManager $extensions = null,
    ) {
        if ($this->content instanceof stdClass) {
            $this->content = json_decode(json_encode($this->content), true);
        }
    }

    public static function from(string | array | stdClass | null $content = null): static
    {
        return new static($content);
    }

    public function to(ContentType $type, bool $toc = false, int $maxDepth = 3): string | array
    {
        return match ($type) {
            ContentType::Html => $this->toHtml(toc: $toc, maxDepth: $maxDepth),
            ContentType::Json => $this->toJson(toc: $toc, maxDepth: $maxDepth),
            ContentType::Markdown => $this->toMarkdown(toc: $toc, maxDepth: $maxDepth),
            ContentType::Text => $this->toText(),
        };
    }

    public function convert(string | array $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function extensions(ExtensionManager $manager): static
    {
        $this->extensions = $manager;

        return $this;
    }

    public function getBlocks(): array
    {
        return Helpers::getToolClasses()->filter(function ($tool) {
            $type = (new $tool())->getType();

            return $type === ToolType::Block || $type === ToolType::StaticBlock;
        });
    }

    public function getEditor(): Editor
    {
        return $this->editor ??= new Editor([
            'extensions' => $this->getExtensions(),
        ]);
    }

    public function getExtensions(): array
    {
        return $this->extensions
            ? $this->extensions::make()->getExtensions()
            : ExtensionManager::make()->getExtensions();
    }

    public function toHtml(bool $toc = false, int $maxDepth = 3, bool $wrapHeadings = false): string
    {
        $editor = $this->getEditor()->setContent($this->content);

        if ($toc) {
            $this->parseHeadings($editor, $maxDepth, $wrapHeadings);
        }

        return $editor->getHTML();
    }

    public function toJson(bool $toc = false, int $maxDepth = 3): array
    {
        $editor = $this->getEditor()->setContent($this->content);

        if ($toc) {
            $this->parseHeadings($editor, $maxDepth);
        }

        return json_decode($editor->getJSON(), true);
    }

    public function toText(): string
    {
        return $this->getEditor()->setContent($this->content)->getText();
    }

    public function toMarkdown(bool $toc = false, int $maxDepth = 3, ?array $options = []): string
    {
        return (new HtmlConverter($options))
            ->convert($this->toHtml(toc: $toc, maxDepth: $maxDepth));
    }

    public function toTOC(int $maxDepth = 3): string
    {
        if (is_string($this->content)) {
            $content = $this->toJson();
        }

        $headings = $this->parseTocHeadings($this->content['content'], $maxDepth);

        return $this->generateNestedTOC($headings, $headings[0]['level']);
    }

    public function parseHeadings(Editor $editor, int $maxDepth = 3, bool $wrapHeadings = false): Editor
    {
        $editor->descendants(function (&$node) use ($maxDepth, $wrapHeadings) {
            if ($node->type !== 'heading') {
                return;
            }

            if ($node->attrs->level > $maxDepth) {
                return;
            }

            if (! property_exists($node->attrs, 'id') || $node->attrs->id === null) {
                $node->attrs->id = str(collect($node->content)->map(function ($node) {
                    return $node?->text ?? null;
                })->implode(' '))->kebab()->toString();
            }

            if ($wrapHeadings) {
                $text = str(collect($node->content)->map(function ($node) {
                    return $node?->text ?? null;
                })->implode(' '))->toString();

                $node->content = [
                    (object) [
                        'type' => 'text',
                        'marks' => [
                            [
                                'type' => 'link',
                                'attrs' => [
                                    'href' => '#' . $node->attrs->id,
                                    'class' => 'toc-link',
                                ],
                            ],
                        ],
                        'text' => $text
                    ],
                ];
            } else {
                array_unshift($node->content, (object) [
                    'type' => 'text',
                    'text' => '#',
                    'marks' => [
                        [
                            'type' => 'link',
                            'attrs' => [
                                'href' => '#' . $node->attrs->id,
                                'class' => 'toc-link',
                            ],
                        ],
                    ],
                ]);
            }
        });

        return $editor;
    }

    public function parseTocHeadings(array $content, int $maxDepth = 3): array
    {
        $headings = [];

        foreach ($content as $node) {
            if ($node['type'] === 'heading') {
                if ($node['attrs']['level'] <= $maxDepth) {
                    $text = collect($node['content'])->map(function ($node) {
                        return $node['text'] ?? null;
                    })->implode(' ');

                    if (! isset($node['attrs']['id'])) {
                        $node['attrs']['id'] = str($text)->kebab()->toString();
                    }

                    $headings[] = [
                        'level' => $node['attrs']['level'],
                        'id' => $node['attrs']['id'],
                        'text' => $text,
                    ];
                }
            } elseif (array_key_exists('content', $content)) {
                $this->parseTocHeadings($content, $maxDepth);
            }
        }

        return $headings;
    }

    public function generateNestedTOC(array $headings, int $parentLevel = 0): string
    {
        $result = '<ul>';
        $prev = $parentLevel;

        foreach ($headings as $item) {
            $prev <= $item['level'] ?: $result .= str_repeat('</ul>', $prev - $item['level']);
            $prev >= $item['level'] ?: $result .= '<ul>';

            $result .= '<li><a href="#' . $item['id'] . '">' . $item['text'] . '</a></li>';

            $prev = $item['level'];
        }

        $result .= '</ul>';

        return $result;
    }
}
