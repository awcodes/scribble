<?php

namespace Awcodes\Scribble;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SplFileInfo;

class Helpers
{
    public static function getBlockClasses(Filesystem $filesystem): Collection
    {
        $path = base_path(str_replace('\\', '/', config('scribble.classes')));

        if (! $filesystem->exists($path)) {
            return collect();
        }

        return collect($filesystem->allFiles($path))
            ->map(function (SplFileInfo $file): string {
                return (string) Str::of(config('scribble.classes'))
                    ->append('\\', $file->getRelativePathname())
                    ->replace(['/', '.php'], '\\', '');
            });
    }
}
