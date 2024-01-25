<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tools\Concerns\InteractsWithMedia;

class Hero extends ScribbleTool
{
    use InteractsWithMedia;

    protected static string $icon = 'heroicon-o-cube';

    protected static string $label = 'Hero';

    protected static bool $shouldShowInSuggestionMenu = true;

    protected static string $view = 'scribble::actions.hero';

    public static function getType(): ToolType
    {
        return ToolType::StaticBlock;
    }

    public static function getCommands(): ?array
    {
        return [
            ['command' => 'toggleHero', 'arguments' => null],
        ];
    }
}
