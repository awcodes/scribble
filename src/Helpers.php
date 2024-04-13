<?php

namespace Awcodes\Scribble;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Helpers
{
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

    public static function makeCommand(string $command, string | array | null $arguments = null): array
    {
        return [
            'command' => $command,
            'arguments' => $arguments ?? [],
        ];
    }
}
