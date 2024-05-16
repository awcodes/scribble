<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Wrappers\Group;
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

    public static function getToolsSchema(array $tools, ?string $statePath): array
    {
        $schema = [];

        foreach ($tools as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupTool) {
                    $groupTool->statePath($statePath);

                    $schema[] = [
                        ...$groupTool->toArray(),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tool->statePath($statePath);

                $schema[] = [
                    ...$tool->toArray(),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $schema;
    }
}
