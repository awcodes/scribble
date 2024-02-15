<?php

namespace Awcodes\Scribble;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use SplFileInfo;

class Helpers
{
    public static function getToolClasses(): Collection
    {
        $corePath = base_path('vendor/awcodes/scribble/src/Tools');
        $path = base_path(str_replace('\\', '/', config('scribble.classes')));

        $filesystem = new Filesystem();

        if (! $filesystem->exists($corePath)) {
            return collect();
        }

        $coreActions = collect($filesystem->allFiles($corePath))
            ->map(function (SplFileInfo $file): string {
                return (string) Str::of('Awcodes\\Scribble\\Tools')
                    ->append('\\', $file->getRelativePathname())
                    ->replace(['/', '.php'], ['\\', ''], '');
            })->filter(function (string $class): bool {
                return ! str_contains($class, 'Concerns');
            });

        if ($filesystem->exists($path)) {
            $customActions = collect($filesystem->allFiles($path))
                ->map(function (SplFileInfo $file): string {
                    return (string) Str::of(config('scribble.classes'))
                        ->append('\\', $file->getRelativePathname())
                        ->replace(['/', '.php'], ['\\', ''], '');
                })->filter(function (string $class): bool {
                    return ! str_contains($class, 'Concerns');
                });
        } else {
            $customActions = collect();
        }

        return $coreActions->merge($customActions);
    }

    public static function isAuthRoute(): bool
    {
        $authRoutes = [
            '/login',
            '/password-reset',
            '/register',
            '/email-verification',
        ];

        return Str::of(Request::path())->contains($authRoutes);
    }
}
