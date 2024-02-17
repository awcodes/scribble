<?php

namespace Awcodes\Scribble;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Helpers
{
    public static function getRegisteredTools(): Collection
    {
        $tools = config('scribble.tools');

        return collect($tools)->mapWithKeys(function ($tool) {
            return [$tool => new $tool];
        });
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
