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

    protected array $registeredToolPaths = [];

    protected array | Closure | null $mergeTagsMap = null;

    public function mergeTagsMap(array | Closure $mergeTagsMap): static
    {
        $this->mergeTagsMap = $mergeTagsMap;

        return $this;
    }

    public function registerToolPath(string $path, string $namespace): static
    {
        if (! File::isDirectory($path) || in_array($path, $this->registeredToolPaths)) {
            return $this;
        }

        $tools = collect(File::allFiles($path))
            ->map(
                fn ($file) => Str::of($file->getRelativePathname())
                    ->before('.php')
                    ->replace('/', '\\')
                    ->start($namespace . '\\')
                    ->toString()
            )
            ->filter(fn ($tool) => is_subclass_of($tool, ScribbleTool::class))
            ->map(fn ($tool) => $tool::make())
            ->all();

        $this->customTools = [...$this->customTools ?? [], ...$tools];
        $this->registeredToolPaths[] = $path;

        return $this;
    }

    public function registerTools(array $tools): static
    {
        $this->customTools = $tools;

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
            ...$this->tools ?? [],
            ...$this->customTools ?? [],
        ])->mapWithKeys(function ($tool) {
            return [$tool->getIdentifier() => $tool];
        });
    }

    public function getTools(array | string $tools): Collection
    {
        $tls = collect();

        $tools = Arr::wrap($tools);

        $toolClassNames = $this->getRegisteredTools()->mapWithKeys(function ($item) {
            return [get_class($item) => $item];
        });

        foreach ($tools as $tool) {
            if ($toolClassNames->keys()->contains($tool)) {
                $tls->push($toolClassNames->only($tool)->sole());
            } else {
                $tls->push($this->getRegisteredTools()->only($tool)->sole());
            }
        }

        return $tls;
    }

    public function getMergeTagsMap(): array
    {
        return $this->evaluate($this->mergeTagsMap) ?? [];
    }
}
