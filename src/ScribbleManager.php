<?php

namespace Awcodes\Scribble;

use Closure;
use Filament\Support\Components\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScribbleManager extends Component
{
    protected ?array $tools = null;

    protected ?array $customTools = null;

    protected ?array $registeredToolPaths = null;

    protected array | Closure | null $mergeTagsMap = null;

    public function mergeTagsMap(array | Closure $mergeTagsMap): static
    {
        $this->mergeTagsMap = $mergeTagsMap;

        return $this;
    }

    public function registerTools(array $tools): static
    {
        $this->customTools = $tools;

        return $this;
    }

    public function registerToolPath(string $path, string $namespace): static
    {
        if (! File::isDirectory($path) || in_array($path, $this->registeredToolPaths ?? [])) {
            return $this;
        }

        $tools = collect(File::allFiles($path))
            ->map(
                fn ($file) => Str::of($file->getRelativePathname())
                    ->trim('.php')
                    ->replace('/', '\\')
                    ->start($namespace . '\\')
                    ->toString()
            )
            ->filter(fn ($tool) => is_subclass_of($tool, ScribbleTool::class))
            ->map(fn ($tool) => $tool::make())
            ->toArray();

        $this->customTools = [...$this->customTools ?? [], ...$tools];
        $this->registeredToolPaths = [...$this->registeredToolPaths ?? [], $path];

        return $this;
    }

    public function tools(array $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function getRegisteredTools(): Collection
    {
        return collect([
            ...$this->tools ?? $this->getDefaultTools(),
            ...$this->customTools ?? [],
        ])->mapWithKeys(function ($tool) {
            return [$tool->getIdentifier() => $tool];
        });
    }

    public function getTools(array | string $tools): Collection
    {
        $tls = collect();

        $tools = Arr::wrap($tools);

        foreach ($tools as $tool) {
            $tls->push($this->getRegisteredTools()->only($tool)->sole());
        }

        return $tls;
    }

    public function getDefaultTools(): array
    {
        return [
            Tools\AlignCenter::make(),
            Tools\AlignEnd::make(),
            Tools\AlignJustify::make(),
            Tools\AlignStart::make(),
            Tools\Blockquote::make(),
            Tools\Bold::make(),
            Tools\BulletList::make(),
            Tools\Code::make(),
            Tools\Details::make(),
            Tools\Divider::make(),
            Tools\Grid::make(),
            Tools\HeadingFive::make(),
            Tools\HeadingFour::make(),
            Tools\HeadingOne::make(),
            Tools\HeadingSix::make(),
            Tools\HeadingThree::make(),
            Tools\HeadingTwo::make(),
            Tools\HorizontalRule::make(),
            Tools\Italic::make(),
            Tools\Link::make(),
            Tools\Media::make(),
            Tools\OrderedList::make(),
            Tools\Paragraph::make(),
            Tools\Strike::make(),
            Tools\Subscript::make(),
            Tools\Superscript::make(),
            Tools\Underline::make(),
        ];
    }

    public function getMergeTagsMap(): array
    {
        return $this->evaluate($this->mergeTagsMap) ?? [];
    }
}
