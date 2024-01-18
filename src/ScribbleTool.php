<?php

namespace Awcodes\Scribble;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

class ScribbleTool
{
    const DEFAULT_TYPE = 'default';

    const CUSTOM_TYPE = 'custom';

    protected static ?string $name = null;

    protected static string $icon = 'heroicon-o-cube-transparent';

    protected static string $title = 'Tool';

    protected static ?string $description = null;

    public static function getToolName(): string
    {
        return 'scribble.' . lcfirst(substr(strrchr(static::class, '\\'), 1));
    }

    public static function getIcon(): string
    {
        return Blade::render('<x-' . static::$icon . ' class="w-5 h-5" stroke-width="1.5"/>');
    }

    public static function getTitle(): string
    {
        return static::$title;
    }

    public static function getDescription(): ?string
    {
        return static::$description ?? null;
    }

    public static function getType(): string
    {
        return static::CUSTOM_TYPE;
    }

    public static function getAction(): string
    {
        return '';
    }

    public static function getActionArguments(): string | array
    {
        return [];
    }
}
