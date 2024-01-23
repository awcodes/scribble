<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Concerns\InteractsWithMedia;

class TestFormBlock extends ScribbleTool
{
    use InteractsWithMedia;

    protected static string $icon = 'heroicon-o-cube';

    protected static string $label = 'Test Form Block';

    protected static bool $shouldShowInSuggestionMenu = true;

    protected static bool $shouldRenderFirst = true;

    protected static string $view = 'scribble::actions.test-form-block';

    public ?string $statePath = null;

    public static function getType(): string
    {
        return static::BLOCK;
    }
}
