<?php

namespace Awcodes\Scribble\Utils;

use Awcodes\Scribble\Enums\ContentType;
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleManager;
use Awcodes\Scribble\Tiptap\Extensions\ClassExtension;
use Awcodes\Scribble\Tiptap\Extensions\IdExtension;
use Awcodes\Scribble\Tiptap\Nodes\ListItem;
use Awcodes\Scribble\Tiptap\Nodes\MergeTag;
use Awcodes\Scribble\Tiptap\Nodes\ScribbleBlock;
use Closure;
use Filament\Support\Concerns\EvaluatesClosures;
use League\HTMLToMarkdown\HtmlConverter;
use stdClass;
use Tiptap\Editor;

class Converter
{
    use EvaluatesClosures;

    protected Editor $editor;

    protected array | Closure | null $mergeTagsMap = null;

    public function __construct(
        public string | array | stdClass | null $content = null,
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

    public function mergeTagsMap(array | Closure $mergeTagsMap): static
    {
        $this->mergeTagsMap = $mergeTagsMap;

        return $this;
    }

    public function getBlocks(): array
    {
        return app(ScribbleManager::class)->getRegisteredTools()->filter(function ($tool) {
            $type = $tool->getType();

            return $type === ToolType::Block || $type === ToolType::StaticBlock;
        });
    }

    public function getEditor(): Editor
    {
        return $this->editor ??= new Editor([
            'extensions' => [
                new \Tiptap\Nodes\Document(),
                new \Tiptap\Nodes\Text(),
                new \Tiptap\Nodes\HardBreak(),
                new ClassExtension(),
                new IdExtension(),
                new ListItem(),
                new ScribbleBlock(),
                new MergeTag(),
                ...$this->getExtensions(),
            ],
        ]);
    }

    public function getExtensions(): array
    {
        return app(ScribbleManager::class)->getRegisteredTools()
            ->filter(function ($tool) {
                return $tool->getConverterExtensions();
            })
            ->map(function ($tool) {
                return $tool->getConverterExtensions();
            })
            ->flatten()
            ->mapWithKeys(function ($extension) {
                return [$extension::class => $extension];
            })
            ->unique()
            ->values()
            ->toArray();
    }

    public function toHtml(bool $toc = false, int $maxDepth = 3, bool $wrapHeadings = false): string
    {
        $editor = $this->getEditor()->setContent($this->content);

        if ($toc) {
            $this->parseHeadings($editor, $maxDepth, $wrapHeadings);
        }

        if (filled($this->getMergeTagsMap())) {
            $this->parseMergeTags($editor);
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
                        'text' => $text,
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

    public function parseMergeTags(Editor $editor): Editor
    {
        $editor->descendants(function (&$node) {
            if ($node->type !== 'mergeTag') {
                return;
            }

            $map = $this->getMergeTagsMap();

            if (filled($map)) {
                $node->content = [
                    (object) [
                        'type' => 'text',
                        'text' => $map[$node->attrs->id] ?? null,
                    ],
                ];
            }
        });

        return $editor;
    }

    public function getMergeTagsMap(): array
    {
        return $this->evaluate($this->mergeTagsMap) ?? app(ScribbleManager::class)->getMergeTagsMap();
    }
}
